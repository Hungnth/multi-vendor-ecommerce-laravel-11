@extends('admin.layouts.master')

@section('content')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Child Category</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Child Category</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.child-category.update', $child_category->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="inputState">Category</label>
                                    <select id="inputState" class="form-control main-category" name="category">
                                        <option value="">Select</option>
                                        @foreach($categories as $category)
                                            <option
                                                {{ $category->id == $child_category->category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Sub Category</label>
                                    <select id="inputState" class="form-control sub-category" name="sub_category">
                                        <option value="">Select</option>
                                        @foreach($sub_categories as $sub_category)
                                            <option
                                                {{ $sub_category->id == $child_category->sub_category->id ? 'selected' : '' }} value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>

                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ $child_category->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option {{ $child_category->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $child_category->status == 0 ? 'selected' : '' }} value="0">
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('body').on('change', '.main-category', function () {
                let id = $(this).val()
                $.ajax({
                    method: 'GET',
                    url: "{{ route('admin.get-sub-categories') }}",
                    data: {
                        id: id
                    },
                    success: function (data) {
                        $('.sub-category').html('<option value="">Select</option>')
                        $.each(data, function (i, item) {
                            $('.sub-category').append(`<option value="${item.id}">${item.name}</option>`)
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(error)
                    }
                })
            });
        })
    </script>
@endpush