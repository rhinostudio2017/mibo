<div class="container-fluid">
    <div class="row">
        <table class="table table-hover">
            <colgroup>
                <col class="tbl-col-img">
                <col>
                <col class="tbl-col-time">
                <col class="tbl-col-buttons">
            </colgroup>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Description</th>
                    <th class="tbl-col-time">Time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody_resource">
                <tr>
                    <td>
                        <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                    </td>
                    <td>
                        Some description for testing..Some description for testing..Some description for testing..Some description for testing..
                    </td>
                    <td class="tbl-col-time">
                        2017-09-25 12:58
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" style="display: inline-block;">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <span class="tbl-col-buttons-text">&nbsp;Delete</span>
                        </button>
                        <button class="btn btn-sm btn-primary right" style="display: inline-block;">
                            <i class="fa fa-remove" aria-hidden="true"></i>
                            <span class="tbl-col-buttons-text">&nbsp;Edit</span>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                    </td>
                    <td>
                        Some description for testing..Some description for testing..Some description for testing..Some description for testing..
                    </td>
                    <td class="tbl-col-time">
                        2017-09-25 12:58
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" style="display: inline-block;">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            <span class="tbl-col-buttons-text">&nbsp;Delete</span>
                        </button>
                        <button class="btn btn-sm btn-primary right" style="display: inline-block;">
                            <i class="fa fa-remove" aria-hidden="true"></i>
                            <span class="tbl-col-buttons-text">&nbsp;Edit</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- add -->
    <div class="row row-padding mb30">
        <button class="btn btn-primary" id="resource_add">
            <span class="fa fa-plus" aria-hidden="true"></span>&nbsp;Add
        </button>
    </div>

    <!-- pagination -->
    <div class="row row-padding mb30">
        <ul class='pagination'>
            <li class="page-item">
                <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
        <div class="page-go">
            Total: <span id="page_total" class="page-total">5</span>
            <input type="text" id="page_number" value="" class="page-text" title="page number">
            <button class="btn btn-primary">Go</button>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="resource_dialog" tabindex="-1" role="dialog" aria-labelledby="resourceDialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resource_dialog_title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>