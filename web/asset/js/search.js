// Initialization
$(function () {
    if ($('#page').val() != 'search') {
        return false;
    }
    // Initialization
    search_attachEvent();
    search_searchResources();
});

/*
 * Admin-Content
 * */
var pager = mibo.util.pager();

// Retrieve resources via api
function search_searchResources() {
    mibo.util.loading.show();
    var data = {};
    data.token = mibo.config.TOKEN;
    data.offset = pager.getItemStart();
    data.limit = pager.getItemCount();
    var startTime = $('#startTime').val(), endTime = $('#endTime').val(),
        keyword = $('#keyword').val(), order = $('#order').val();
    startTime && (data.startTime = startTime);
    endTime && (data.endTime = endTime);
    keyword && (data.keyword = keyword);
    order && (data.order = order);
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
        var resourceTBody = $('#result_tbody').empty(), html;
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
            html.push('<img class="img-icon" src="', data.response.data.rows[p]['poster_link'], '">');
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
        search_attachResourceEvent();
        // Pagination re-settings
        pager.setTotalItem(data.response.data.totalRowCount);
        $('#page_total').html(pager.getTotalPage());
        $('#page_number').val('');
        $('#page_active').html(pager.getPage());
        if (pager.isFirstPage()) {
            $('#page_previous').hasClass('disabled') || $('#page_previous').addClass('disabled');
        } else {
            !$('#page_previous').hasClass('disabled') || $('#page_previous').removeClass('disabled');
        }
        if (pager.isLastPage()) {
            $('#page_next').hasClass('disabled') || $('#page_next').addClass('disabled');
        } else {
            !$('#page_next').hasClass('disabled') || $('#page_next').removeClass('disabled');
        }
        // Stiky footer
        stikyFooter();
        mibo.util.loading.hide();
    }).fail(function () {
        mibo.util.system.error();
    });
}

function search_attachResourceEvent() {
    $('#result_tbody tr').click(function (e) {
        e.preventDefault();
        var data = $(this).data(), url = '/play';
        mibo.util.form.post(url, data);
    });
}

function search_attachEvent() {
    // Pagination buttons
    $('#page_previous a').click(function (e) {
        if (!pager.isFirstPage()) {
            pager.setPage(pager.getPage() - 1);
            search_searchResources();
        }
    });
    $('#page_next a').click(function (e) {
        if (!pager.isLastPage()) {
            pager.setPage(pager.getPage() + 1);
            console.log('target page: ', pager.getPage());
            search_searchResources();
        }
    });
    $('#page_go').click(function (e) {
        var pageNumber = ~~$('#page_number').val();
        if (pageNumber  == 0 || pageNumber > pager.getTotalPage()) {
            mibo.util.system.error('Please input an page number between 1 and ' + pager.getTotalPage());
            return;
        }
        pager.setPage(pageNumber);
        search_searchResources();
    });
}