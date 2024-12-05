<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner' => ['required', 'image', 'max:5120'],
            'type' => ['string', 'max:255'],
            'title' => ['required', 'max:255'],
            'starting_price' => ['max:255'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $slider = new Slider();

        // Handle file upload
        $image_path = $this->upload_image($request, 'banner', 'uploads');

        $slider->banner = $image_path;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        flash()->flash('success','Created Successfully!', [] ,'Slider');

        return redirect()->route('admin.slider.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner' => ['nullable', 'image', 'max:5120'],
            'type' => ['string', 'max:255'],
            'title' => ['required', 'max:255'],
            'starting_price' => ['max:255'],
            'btn_url' => ['url'],
            'serial' => ['required', 'integer'],
            'status' => ['required'],
        ]);

        $slider = Slider::findOrFail($id);

        // Handle file upload
        $image_path = $this->update_image($request, 'banner', 'uploads', $slider->banner);

        $slider->banner = $image_path ?? $slider->banner;
        $slider->type = $request->type;
        $slider->title = $request->title;
        $slider->starting_price = $request->starting_price;
        $slider->btn_url = $request->btn_url;
        $slider->serial = $request->serial;
        $slider->status = $request->status;
        $slider->save();

        flash()->flash('success','Updated Successfully!', [] ,'Slider');

        return redirect()->route('admin.slider.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::findOrFail($id);
        $this->delete_image($slider->banner);
        $slider->delete();

        return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
    }
}
