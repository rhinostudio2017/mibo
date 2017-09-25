// Initialization
$(function () {
    if ($('#page').val() != 'admin') {
        return false;
    }
    // Initialization
    fetchResources();
});

/*
 * Admin-Content
 * */
var pager = mibo.util.pager();

// Retrieve resources via api
function fetchResources(data) {
    mibo.util.loading.show();
    var data = data || {};
    data.token = data.token || mibo.config.TOKEN;
    var ajp = mibo.util.http.post(mibo.config.API + 'resource/fetch', data);
    mibo.promiseq.admin_resource_fetch = ajp;
    ajp.done(function (data, status, ajXhr) {
        console.log('data', data);
        // Construct resource tbody
        if (data.response.status != 'success') {
            mibo.util.system.error(data.response.message);
            return;
        }

        var html = [];
        for(var p in data.response.data.rows){
            html.push('<tr>');
            html.push('<td>');
            html.push('<img class="img-icon" src="https://www.google.co.nz/imgres?imgurl=http%3A%2F%2F2.bp.blogspot.com%2F--FAn2oUtH_Y%2FVaVDZ89gFfI%2FAAAAAAAAJsA%2Fh6F_ReTbWLI%2Fs1600%2Fa-cute-lovely-birds-images.jpg&imgrefurl=http%3A%2F%2Floving2you.blogspot.com%2F2013%2F09%2Fbeautiful-nice-and-lovely-birds-images.html&docid=LcFwFUx6EaIBDM&tbnid=1yIUkD83FB7pmM%3A&vet=10ahUKEwiRtZyyz7_WAhVBllQKHX5QCvsQMwg2KBEwEQ..i&w=1600&h=900&client=firefox-b-ab&bih=711&biw=1373&q=lovely&ved=0ahUKEwiRtZyyz7_WAhVBllQKHX5QCvsQMwg2KBEwEQ&iact=mrc&uact=8">');
            html.push('</td>');
            html.push('<td>', data.response.data.rows[p]['description'], '</td>');
            html.push('<td>', data.response.data.rows[p]['produce_time'], '</td>');
            html.push('<td>');
            html.push('<button class="btn btn-sm btn-primary" style="display: inline-block;">');
            html.push('<i class="fa fa-remove" aria-hidden="true"></i>');
            html.push('<span class="tbl-col-buttons-text">&nbsp;Edit</span>');
            html.push('</button>');
            html.push('<button class="btn btn-sm btn-danger right" style="display: inline-block;">');
            html.push('<i class="fa fa-pencil" aria-hidden="true"></i>');
            html.push('<span class="tbl-col-buttons-text">&nbsp;Delete</span>');
            html.push('</button>');
            html.push('</td>');
            html.push('</tr>');
        }
        $('#tbody_resource').html(html.join(''));

        pager.setTotalPage(data.response.data.totalRowCount);
        $('#page_total').html(pager.getTotalPage());

        mibo.util.loading.hide();
    }).fail(function () {
        mibo.util.system.error();
    });
}

