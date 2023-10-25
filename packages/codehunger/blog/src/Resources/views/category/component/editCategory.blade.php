<!-- Knowledgebase Category Create -->
<div class="modal fade" id="knowledgebaseCategoryUpdateModal" tabindex="-1" aria-labelledby="knowledgebaseCategoryUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="knowledgebaseCategoryUpdateModalLabel">
                        Update Blog Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input required type="text" name="name" class="form-control" placeholder="Enter Blog Category Name">
                                <div class="invalid-feedback">
                                    Please Enter Valid Category Name
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea required type="text" name="description" class="form-control" rows="5" placeholder="Enter Blog Category Description"></textarea>
                                <div class="invalid-feedback">
                                    Please Enter Valid Blog Category Description
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