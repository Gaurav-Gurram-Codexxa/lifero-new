@role('Super Admin')
<a href="#" class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#import">
   Import
</a>

<div id="import" class="modal fade "  aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Import</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{route('lead.import')}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
                       <div class="modal-body">

                <div class="row">
                    <div class="form-group mb-5">
                        <label for="name" class="form-label">Excel:</label>
                        <span class="required"></span>
                        <input class="form-control" minlength="2" accept=".xlsx"  name="file" type="file">
                    </div>


                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="submit" class="btn btn-primary m-0" data-loading-text="<span class='spinner-border spinner-border-sm'></span> Processing...">Save</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endrole
