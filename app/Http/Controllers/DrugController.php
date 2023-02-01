<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;
use Validator;
class DrugController extends Controller
{

    // rules for drugs
    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'company' => 'required|min:4',
            'price' => 'required|integer',
            'cure' => 'required|min:10',
            'qty' => 'required|integer',
            'drug_type' => 'required',
            'hcpi' => 'required',
            'dosage' => 'required',
            'active_ingredients' => 'required',
            'nafdac' => 'required',
            'expiry_date' => 'required',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all drugs that belongs to authenticated vendor
        $drugs = Drug::where('vendor_id', auth()->id())->get();

        return $drugs;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate drug request
        $rules = $this->rules();
        $validator = Validator::make($request->except('image'),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else{
            //create a new drug
            // upload photo
            $fileName = Null;
            if($request->image){
                $fileName = time().'.'.explode('/',explode(':',substr($request->image,0,strpos($request->image,';')))[1])[1];
                \Image::make($request->image)->save(public_path('images/').$fileName);
            }
            $drug = Drug::create([
                'name' => $request->name,
                'company' => $request->company,
                'price' => $request->price,
                'effects' => $request->effects,
                'interaction' => $request->interaction,
                'cure' => $request->cure,
                'vendor_id' => auth()->user()->id,
                'qty' => $request->qty,
                'overdose' => $request->overdose,
                'hcpi' => $request->hcpi,
                'active_ingredients' => $request->active_ingredients,
                'drug_type' => $request->drug_type,
                'dosage' => $request->dosage,
                'note' => $request->note,
                'photo' => $fileName,
                'nafdac' => $request->nafdac,
                'expiry_date' => $request->expiry_date
            ]);
            return response()->json(['drug' => $drug,'message' => 'Drug added successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $drug = Drug::findOrFail($id);
        return $drug;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function edit(Drug $drug)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate drug request
        $rules = $this->rules();
        $validator = Validator::make($request->except('image'),$rules);
        if($validator->fails()){
            return response()->json(['error' => $validator->errors()],400);
        }
        else {
            $drug = Drug::find($id);
            $drug->name = $request->name;
            $drug->company = $request->company;
            $drug->price = $request->price;
            $drug->effects = $request->effects;
            $drug->interaction = $request->interaction;
            $drug->cure = $request->cure;
            $drug->qty = $request->qty;
            $drug->overdose = $request->overdose;
            $drug->hcpi = $request->hcpi;
            $drug->active_ingredients = $request->active_ingredients;
            $drug->drug_type = $request->drug_type;
            $drug->dosage = $request->dosage;
            $drug->note = $request->note;
            $drug->nafdac = $request->nafdac;
            $drug->expiry_date = $request->expiry_date;
            if($drug->photo){
                $path = public_path().'/images/'.$drug->photo;
                if(file_exists($path)){
                    unlink($path);
                }
            }
            if($request->image){
                $imageName = time().'.'.explode('/',explode(':',substr($request->image,0,strpos($request->image,';')))[1])[1];
                \Image::make($request->image)->save(public_path('images/').$imageName);
                $drug->photo = $imageName;
            }

            $drug->save();
            return response()->json(['message' => 'Drug updated successfully','drug' => $drug]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drug  $drug
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drug = Drug::find($id);
        if($drug->photo !== Null){
            $path = public_path().'/'.$drug->photo;
            unlink($path);
        }
        $drug->delete();
    }

    public function drugPurchaseFrequency(){
        
    }
}
