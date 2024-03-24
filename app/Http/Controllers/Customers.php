<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Customer;

class Customers extends Controller
{
    public function index()
    {
        //get customers
        $customers = Customer::when(request()->q, function ($customers) {
            $customers = $customers->where('name', 'like', '%' . request()->q . '%');
        })->latest()->paginate(5);

        //return inertia
        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    public function create()
    {
        return Inertia::render('Customers/Create');
    }
    public function store(Request $request)
    {
        // Memvalidasi data dengan nomor telepon yang sudah dimodifikasi
        $this->validate($request, [
            'name'      => 'required',
            'no_telp'   => 'required|unique:customers',
            'address'   => 'required',
        ]);

        // Membuat pelanggan baru dengan nomor telepon yang sudah dimodifikasi
        Customer::create([
            'name'      => $request->name,
            'no_telp'   => $request->no_telp,
            'address'   => $request->address,
        ]);


        //redirect
        return redirect()->route('customers.index')->with('message', 'Customers added successfully!');
    }

    public function edit(Customer $customer)
    {
        return Inertia::render('Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, Customer $customer)
    {
        /**
         * validate
         */
        $this->validate($request, [
            'name'      => 'required',
            'no_telp'   => 'required|unique:customers,no_telp,' . $customer->id,
            'address'   => 'required',
        ]);

        //update customer
        $customer->update([
            'name'      => $request->name,
            'no_telp'   => $request->no_telp,
            'address'   => $request->address,
        ]);

        //redirect
        return redirect()->route('customers.index')->with('message', 'Customers updated successfully!');
    }

    public function destroy($id)
    {
        //find customer by ID
        $customer = Customer::findOrFail($id);

        //delete customer
        $customer->delete();

        //redirect
        return redirect()->route('customers.index');
    }
}
