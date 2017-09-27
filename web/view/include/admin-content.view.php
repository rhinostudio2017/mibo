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
            <li class="page-item" id="page_previous">
                <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="#" id="page_active">1</a>
            </li>
            <li class="page-item" id="page_next">
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
    <div class="modal-dialog modal-dialog-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resource_dialog_title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row" id="modal-error">
                        <div class="col-sm-12">
                            <label class="text-danger"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_v_url"><span class="text-danger">*</span>&ensp;Video:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_v_url" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_i_url"><span class="text-danger">*</span>&ensp;Image:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_i_url" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_name"><span class="text-danger">*</span>&ensp;Name:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_name" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_description">Description:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_description" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_author">Author:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_author" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="ipt_venue">Venue:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" id="ipt_venue" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="modal_check">Check</button>
                <button type="button" class="btn btn-primary" id="modal_save">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_dialog" tabindex="-1" role="dialog" aria-labelledby="confirmDialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-custom" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Dialog</h5>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <label></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="confirm_no">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm_yes">Yes</button>
            </div>
        </div>
    </div>
</div>