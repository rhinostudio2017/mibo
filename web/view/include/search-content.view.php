<!-- new released -->
<div class="container-fluid section">
    <div class="row">
        <div class="col-sm-6 section-header text-success">
            <span class="section-label">Search Results</span>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <tbody id="result_tbody">
                <tr>
                    <td>
                        <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                    </td>
                    <td class="tbl-col-author">
                        <p class="td-row">test name 01</p>
                        <p class="td-row">author 01</p>
                    </td>
                    <td class="tbl-col-time">
                        <p class="td-row">2017-09-25 12:58:23</p>
                        <p class="td-row">
                            <i class="fa fa-eye" aria-hidden="true"></i>40,000
                        </p>
                    </td>
                    <td>
                        Some description for testing..Some description for testing..Some description for testing..Some
                        description for testing..
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                    </td>
                    <td class="tbl-col-author">
                        <p class="td-row">test name 01</p>
                        <p class="td-row">author 01</p>
                    </td>
                    <td class="tbl-col-time">
                        <p class="td-row">2017-09-25 12:58:23</p>
                        <p class="td-row">
                            <i class="fa fa-eye" aria-hidden="true"></i>40,000
                        </p>
                    </td>
                    <td>
                        Some description for testing..Some description for testing..Some description for testing..Some
                        description for testing..
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- pagination -->
    <div class="row row-padding mb30">
        <ul class='pagination'>
            <li class="page-item" id="page_previous">
                <a class="page-link" href="javascript:void(0);">Previous</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="javascript:void(0);" id="page_active">1</a>
            </li>
            <li class="page-item" id="page_next">
                <a class="page-link" href="javascript:void(0);">Next</a>
            </li>
        </ul>
        <div class="page-go">
            Total: <span id="page_total" class="page-total">5</span>
            <input type="text" id="page_number" value="" class="page-text" title="page number">
            <button class="btn btn-primary" id="page_go">Go</button>
        </div>
    </div>
</div>