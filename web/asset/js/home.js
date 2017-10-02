// Initialization
$(function () {
    if ($('#page').val() != 'home') {
        return false;
    }
    // Initialization
    home_attachEvent();
    home_searchResources({}, 'h_n_tbody');
    home_searchResources({'order':'views'}, 'h_t_tbody');
});

/*
 * Home-Content
 * */

// Retrieve resources via api
function home_searchResources(criteria, containerId) {
    mibo.util.loading.show();
    var data = {};
    data.token = mibo.config.TOKEN;
    data.offset = criteria.offset || 0;
    data.limit = criteria.limit || 10;
    data.keyword = criteria.keyword || null;
    data.order = criteria.order || null;
    var ajp = mibo.util.http.post(mibo.config.API + 'resource/fetch', data);
    mibo.promiseq.admin_resource_fetch = ajp;
    ajp.done(function (data, status, ajXhr) {
        console.log('data', data);
        // Construct resource tbody
        if (data.response.status != 'success') {
            mibo.util.loading.hide();
            mibo.util.system.error(data.response.message);
            return;
        }
        var resourceTBody = $('#' + containerId).empty(), html;
        if (data.response.data.totalRowCount == 0) {
            $('<tr><td><p>There is no result based on your search keyword...</p></td></tr>').appendTo(resourceTBody);
            stikyFooter();
            mibo.util.loading.hide();
            return;
        }
        for (var p in data.response.data.rows) {
            html = [];
            html.push('<tr id="', data.response.data.rows[p]['id'], '">');
            html.push('<td class="tbl-col-img">');
            html.push('<img class="img-icon" src="', decodeURIComponent(data.response.data.rows[p]['poster_link']), '">');
            html.push('</td>');
            html.push('<td class="tbl-col-author">');
            html.push('<p class="td-row">', data.response.data.rows[p]['name'], '</p>');
            html.push('<p class="td-row">', data.response.data.rows[p]['author'], '</p>');
            html.push('</td>');
            html.push('<td class="tbl-col-time">');
            html.push('<p class="td-row">', data.response.data.rows[p]['produce_time'], '</p>');
            html.push('<p class="td-row">', '<i class="fa fa-eye" aria-hidden="true"></i>', mibo.util.format.number2kview(data.response.data.rows[p]['views']), '</p>');
            html.push('</td>');
            html.push('<td>', data.response.data.rows[p]['description'], '</td>');
            html.push('</tr>');
            $(html.join('')).data(data.response.data.rows[p]).appendTo(resourceTBody);
        }
        home_attachResourceEvent();
        // Stiky footer
        stikyFooter();
        mibo.util.loading.hide();
    }).fail(function () {
        mibo.util.system.error();
    });
}

function home_attachResourceEvent() {
    $('#h_n_tbody tr, #h_t_tbody tr').click(function (e) {
        e.preventDefault();
        var data = $(this).data(), url = '/play';
        mibo.util.form.post(url, data);
    });
}

function home_attachEvent() {
    // View more link
    $('#btn_more_new_pc, #btn_more_new_mb, #btn_more_top_pc, #btn_more_top_mb').click(function (e) {
        var data = {}, url = '/search';
        if ($(this).attr('type') == 'top') {
            data.order = 'views';
        }
        mibo.util.form.post(url, data);
    });
}