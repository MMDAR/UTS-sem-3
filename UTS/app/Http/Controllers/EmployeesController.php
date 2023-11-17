<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;

class EmployeesController extends Controller
{
    // Membuat method index
    public function index()
    {
        // Menggunakan Model Employees untuk select data
        $employees = Employees::all();
        $data = [
            'message' => 'Get All Employees',
            'data' => $employees
        ];

        // jika data kosong
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'kosong',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        return response()->json($data, 200);
    }

    // Membuat method find dengan id
    public function show($id)
    {
        $employees = Employees::find($id);
        if (!$employees) {
            $data = [
                'message' => 'Data not found'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'message' => 'Show detail resource',
            'data' => $employees
        ];
        return response()->json($data, 200);
    }
    // Menambahkan method store 
    public function store(Request $request)
    {

        // validasi data request
        $validatedData = $request->validate([
            "name" => "required",
            "gender" => "required",
            "phone" => "required",
            "address" => "required",
            "email" => "email|required",
            "status" => "required",
            "hired_on" => "required",
        ]);

        // Menggunakan model Student
        $employees = Employees::create($validatedData);

        $data = [
            'message' => 'Employees is created succesfully',
            'data' => $employees,
        ];

        // Mengembalikan data (JSON) dan kode 201
        return response()->json($data, 201);
    }

    // Membuat method update
    public function update(Request $request, $id)
    {
        $employees = Employees::find($id);

        if (!$employees) {
            $data = [
                'message' => 'Employees not found'
            ];
            return response()->json($data, 404);
        }

        $employees->update([
            'name' => $request->name ?? $employees->name,
            'gender' => $request->gender ?? $employees->gender,
            'phone' => $request->phone ?? $employees->phone,
            'address' => $request->address ?? $employees->address,
            'email' => $request->email ?? $employees->email,
            'status' => $request->status ?? $employees->status,
            'hired_on' => $request->hired_on ?? $employees->hired_on

        ]);
        $data = [
            'message' => 'Employees is updated successfully',
            'data' => $employees,
        ];

        return response()->json($data, 200);
    }

    // Method untuk menghapus karyawan dengan id
    public function destroy($id)
    {

        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Employees not found'], 404);
        }

        $employees->delete();

        $data = [
            'message' => 'Employees has been deleted successfully',
        ];

        return response()->json($data, 200);
    }


    // Menambahkan method untuk mencari karyawan berdasarkan nama
    public function search(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string',
        ]);

        // Menggunakan Model Employees untuk melakukan pencarian berdasarkan nama
        $employees = Employees::where('name', 'like', '%' . $request->input('name') . '%')->get();

        // Jika tidak ada karyawan yang ditemukan
        if ($employees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang ditemukan dengan nama tersebut',
            ];
            return response()->json($data, 404);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Search Employees by Name',
            'data' => $employees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang aktif
    public function active()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $activeEmployees = Employees::where('status', 'aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($activeEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Active Employees',
            'data' => $activeEmployees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang tidak aktif
    public function inactive()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $inactiveEmployees = Employees::where('status', 'tidak aktif')->get();

        // Jika tidak ada karyawan yang aktif
        if ($inactiveEmployees->isEmpty()) {
            $data = [
                'message' => 'Semua karyawan aktif',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Inactive Employees',
            'data' => $inactiveEmployees,
        ];
        return response()->json($data, 200);
    }

    // Menambahkan method untuk mendapatkan karyawan yang terminated
    public function terminated()
    {
        // Menggunakan Model Employees untuk select data karyawan yang aktif
        $terminEmployees = Employees::where('status', 'terminated')->get();

        // Jika tidak ada karyawan yang aktif
        if ($terminEmployees->isEmpty()) {
            $data = [
                'message' => 'Tidak ada karyawan yang dipecat',
            ];
            return response()->json($data, 204);
        }

        // Mengirim data (json) dan kode 200
        $data = [
            'message' => 'Get Terminated Employees',
            'data' => $terminEmployees,
        ];
        return response()->json($data, 200);
    }

}

