<!-- Knowledgebase Category Create -->
<div class="modal fade" id="knowledgebaseSubCategoryCreateModal" tabindex="-1" aria-labelledby="knowledgebaseSubCategoryCreateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.subcategory.store') }}" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="knowledgebaseSubCategoryCreateModalLabel">
                        Create Blog Sub-Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label">Blog Category <span class="text-danger">*</span></label>
                                <select required class="form-control" name="blog_category_id">
                                    <option selected disabled>Select Blog Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Blog Category
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input required type="text" name="name" class="form-control" placeholder="Enter Blog Sub-Category Title">
                                <div class="invalid-feedback">
                                    Please Enter Blog Sub-Category Title
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea required type="text" name="description" class="form-control" rows="5" placeholder="Please Enter Sub-Category Description"></textarea>
                                <div class="invalid-feedback">
                                    Please Enter Valid Sub-Category Description
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>