<?php

namespace App\Http\Controllers\Admin;

use App\Models\DroppedOrCancel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Leads;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Exports\DroppedOrCancelExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Carbon;

class DroppedOrCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $assignedName = User::select('id', 'name')->distinct()->get();

        if (auth()->id() == 1) {
            $leads = Leads::with('products', 'user','assign')
            ->where('status', 'Dropped or Cancel')
            ->orderBy('is_pinned', 'DESC') // Pinned first
            ->orderBy('created_at', 'DESC')
            ->get();
        } elseif (auth()->id() == 2) {
              // Admin sees leads assigned to them
                $leads = Leads::with('products', 'user','assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Dropped or Cancel')
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
              // Regular users see only leads they created
                $leads = Leads::with('products', 'user','assign')
                ->where('user_id', $user->id)
                ->where('status', 'Dropped or Cancel')
                ->orderBy('is_pinned', 'DESC') // Pinned first
                ->orderBy('created_at', 'DESC')
                ->get();

        }

        $products = Products::all();
        $selectedProducts = [];

        $assignedName = User::select('id', 'name')->distinct()->get();

        return view('admin.droppedOrCancel.index', compact('leads', 'products', 'selectedProducts','assignedName'))
        ->with('message', $leads->isEmpty() ? 'No leads found.' : null);
    }


    public function togglePin(Leads $lead)
    {
        abort_if(Gate::denies('lead_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lead->update(['is_pinned' => !$lead->is_pinned]);

        return back()->with('success', 'Lead pin status updated successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DroppedOrCancel  $droppedOrCancel
     * @return \Illuminate\Http\Response
     */
    public function show(DroppedOrCancel $droppedOrCancel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DroppedOrCancel  $droppedOrCancel
     * @return \Illuminate\Http\Response
     */
    public function edit(DroppedOrCancel $droppedOrCancel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DroppedOrCancel  $droppedOrCancel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DroppedOrCancel $droppedOrCancel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DroppedOrCancel  $droppedOrCancel
     * @return \Illuminate\Http\Response
     */
    public function destroy(DroppedOrCancel $droppedOrCancel)
    {
        //
    }

    // excel
    public function exportinDroppedOrCancel(Request $request)
    {
        $user = auth()->user();

        if ($user->id == 1) {
            $leads = Leads::with('products', 'user', 'assign')->where('status', 'Dropped or Cancel')->get();
        } elseif ($user->id == 2) {
            $leads = Leads::with('products', 'user', 'assign')
                ->where('assigned_name', $user->id)
                ->where('status', 'Dropped or Cancel')->get();
        } else {
            $leads = Leads::with('products', 'user', 'assign')
                ->where(function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->orWhere('assigned_name', $user->id);
                })
                ->where('status', 'Dropped or Cancel')->get();
        }

        $data = $leads->map(function ($lead) {
            return [
                'id' => $lead->id,
                // 'user' => optional($lead->user)->name,
                'assigned_By' => optional($lead->assignedBy)->name,
                'assigned_to' => optional($lead->assign)->name,
                'name' => $lead->name,
                'mobile' => $lead->mobile,
                'email' => $lead->email,
                'address' => $lead->address,
                'industry' => $lead->industry,
                'purpose' => $lead->purpose,
                'status' => $lead->status,
                'source' => $lead->source,
                'product_names' => $lead->products->pluck('name')->implode(', '),
                'remarks' => $lead->remarks,
                'demo_date' => $lead->demo_date,
                'demo_time' => $lead->demo_time,
                'follow_date' => $lead->follow_date,
                'follow_time' => $lead->follow_time,
                'created_at' => optional($lead->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => optional($lead->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return Excel::download(new DroppedOrCancelExport($data), 'ClosedOrWon_' . now()->format('Ymd_His') . '.xlsx');
    }
}
