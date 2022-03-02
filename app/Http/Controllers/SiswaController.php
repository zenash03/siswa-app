<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswas = Siswa::orderBy('no_absen', 'asc')->get();
        $response = [
            'message' => 'Data berhasil ditampilkan',
            'data' => $siswas
        ];
        return response()->json($response, Response::HTTP_OK);
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
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'kelas' => ['required', 'numeric'],
            'no_absen' => ['required', 'numeric'],
            'jurusan' => ['required' , 'in:TKJ,AKL,BDP'],
            'deskripsi' => ['required'] 
        ]);
        if ($validator -> fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $siswa = Siswa::create($request->all());
            $response = [
                'message' => 'Data Berhasil ditambahkan',
                'data' => $siswa
            ];
            return response()->json($response, Response::HTTP_CREATED);

        }catch (QueryException $exc){
            return response()->json([
                'message' => 'failed' . $exc->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::findOrFail($id);
        $response = [
            'message' => 'Data ditemukan',
            'data' => $siswa
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::where('id', $id)->firstOrFail();
        
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'kelas' => ['required', 'numeric'],
            'no_absen' => ['required', 'numeric'],
            'jurusan' => ['required' , 'in:TKJ,AKL,BDP'],
            'deskripsi' => ['required'] 
        ]);
        if ($validator -> fails()){
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $siswa->update($request->all());
            $response = [
                'message' => 'Data Berhasil di Update',
                'data' => $siswa
            ];
            return response()->json($response, Response::HTTP_OK);

        }catch (QueryException $exc){
            return response()->json([
                'message' => 'failed' . $exc->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        try {
            $siswa->delete();
            $response = [
                'message' => 'Siswa Deleted',
            ];

            return response()->json($response, Response::HTTP_OK);
        }
        catch(QueryException $e ) {
            return response()->json([
                'message' => 'Failed' . $e->errorInfo
            ]);
        }
    }
}
