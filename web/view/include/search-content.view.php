<!-- new released -->
<div class="container-fluid section">
    <div class="row">
        <div class="col-sm-6 section-header text-success">
            <span class="section-label">New Released</span>
        </div>
        <div class="col-sm-6 section-header link-more-pc">
            <a class="btn btn-outline-success section-link right" href="javascript:void(0);" id="btn_more_new" type="new">view more>></a>
        </div>
    </div>
    <div class="row">
        <table class="table table-hover">
            <tbody id="h_n_tbody">
            <tr>
                <td>
                    <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                </td>
                <td class="tbl-col-author">
                    <span class="resource-author">tianmao</span>
                    <span class="resource-name">aaa bb ccc</span>
                </td>
                <td class="tbl-col-time">
                    <span class="resource-author">2017-09-25 12:58</span>
                    <span class="resource-name">40,000</span>
                </td>
                <td>
                    Some description for testing..Some description for testing..Some description for testing..Some description for testing..
                </td>
            </tr>
            <tr>
                <td>
                    <img class="img-icon" src="<?php echo $asset; ?>images/t.png">
                </td>
                <td class="tbl-col-author">
                    <span class="resource-author">tianmao</span>
                    <span class="resource-name">aaa bb ccc</span>
                </td>
                <td class="tbl-col-time">
                    <span class="resource-author">2017-09-25 12:58</span>
                    <span class="resource-name">40,000</span>
                </td>
                <td>
                    Some description for testing..Some description for testing..Some description for testing..Some description for testing..
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