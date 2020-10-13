<?php

namespace App\Http\Controllers\Backend;

use App\Model\Commission;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $commissions = Commission::all();
        $vendors = $this->userRepository->getByRole( 'vendor' );
        return view('admin.commissions.index', compact('commissions', 'vendors'));
    }

//    public function create($id)
//    {
//        $vendor = User::findOrFail($id);
//        return view('admin.commissions.create', compact('vendor'));
//    }
//
//    public function store(Request $request)
//    {
//        $commission = new Commission();
//        $commission->user_id = $request->vendor_id;
//        $commission->commission = $request->commission;
//        $commission->save();
//        return redirect()->back();
//    }

    public function edit($id)
    {
        $commission = Commission::where('user_id', $id)->first();
        $vendor = User::findOrFail($id);
        return view('admin.commissions.edit', compact('commission', 'vendor'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'commission' => 'required|numeric'
        ]);

        Commission::updateOrCreate(['user_id' => $request->vendor_id], ['commission' => $request->commission]);
//        if (Commission::where('user_id', $request->vendor_id)->first() ) {
//            $commission = Commission::where('user_id', $request->vendor_id)->first();
//        }
//        else
//        {
//            $commission = new Commission();
//        }
//        $commission->user_id = $request->vendor_id;
//        $commission->commission = $request->commission;
//        $commission->update();
        return redirect()->route('admin.commissions.index')->with(['success' => 'Commission successfully updated!']);
    }

    public function destroy($id)
    {
        $commission = Commission::findOrFail($id);
        $commission->delete();
        return redirect()->back()->with(['success' => 'Commission successfully deleted!']);
    }
}
