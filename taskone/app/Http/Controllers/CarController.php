<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('user')->orderBy('id', 'desc')->paginate(10);

        return view('cars.dashboard', [
            'cars' => $cars,
        ]);
    }


    public function create()
    {
        return view('cars.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|integer',
        ]);

        $car = new Car([
            'make' => $request->input('make'),
            'model' => $request->input('model'),
            'year' => $request->input('year'),
        ]);

        // Assign the user_id based on the currently authenticated user
        $car->user_id = auth()->user()->id;

        $car->save();

        return redirect()->route('admin.car.index')->with('success', 'Car created successfully');
    }


    public function edit($id){
        $car = Car::find($id);

        return view('cars.edit',[
            'car' => $car
        ]);
    }



    public function update(Request $request,$id){
        
        // Validation
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        
        $car = Car::find($id);

        $car->make = $request->make;

        $car->model = $request->model;

        $car->year = $request->year;

        $car->save();

        return redirect()->route('admin.car.index')->with('success', 'Car was updated successfully');
    }



    public function destroy(Request $request,$id){

        $car = Car::find($id);

        $car->delete();

        return redirect()->route('admin.car.index')->with('success', 'Car was deleted successfully');
    }
}
