// Initialization
$(function () {
    if ($('#page').val() != 'admin') {
        return false;
    }
    // Initialization
    if ($('#form_login').length != 0) {
        formAttachEvent();
    } else {
        attachEvent();
        fetchResources();
    }
});

/*
 * Admin-Login
 * */
function formAttachEvent() {
    // Form event
    $('#form_login').submit(function (e) {
        e.preventDefault();
        var validate = formValidate();
        if (validate !== true) {
            mibo.util.system.error(validate);
            return;
        }

        // Check login via api
        mibo.util.loading.show();
        var data = data || {};
        data.token = data.token || mibo.config.TOKEN;
        data.username = $('#username').val();
        data.password = $('#password').val();
        var ajp = mibo.util.http.post(mibo.config.API + 'user/login', data);
        mibo.promiseq.admin_user_login = ajp;
        ajp.done(function (data, status, ajXhr) {
            console.log('data', data);
            // Construct resource tbody
            if (data.response.status != 'success') {
                $('#username, #password').addClass('color-error');
                mibo.util.loading.hide();
                mibo.util.system.error(data.response.message);
                return;
            }

            mibo.util.loading.hide();
            window.location.href = '/admin';
        }).fail(function () {
            mibo.util.system.error();
        });
    });

    // Focus events
    $('#username, #password').focus(function (e) {
        $('#username').hasClass('color-error') && $('#username').removeClass('color-error');
        $('#password').hasClass('color-error') && $('#password').removeClass('color-error');
    });
}

function formValidate() {
    var username = $('#username').val(), password = $('#password').val(), flag = 1;
    if (username.trim() == '' || username.trim().length > mibo.modal.user.username.length()) {
        $('#username').addClass('color-error');
        return 'Username cannot be empty, and the length must less than ' + mibo.modal.user.username.length() + '.';
    }
    if (password.trim() == '' || password.trim().length > mibo.modal.user.password.length()) {
        $('#password').addClass('color-error');
        return 'Password cannot be empty, and the length must less than ' + mibo.modal.user.password.length() + '.';
    }

    var regexp = /[a-zA-Z0-9_]+/;
    if (!regexp.test(username)) {
        $('#username').addClass('color-error');
        return 'Username must only contain characters, numbers and underscore.';
    }
    if (!regexp.test(password)) {
        $('#password').addClass('color-error');
        return 'Password must only contain characters, numbers and underscore.';
    }
    return true;
}

/*
 * Admin-Content
 * */
var pager = mibo.util.pager();

// Retrieve resources via api
function fetchResources(data) {
    mibo.util.loading.show();
    var data = data || {};
    data.token = data.token || mibo.config.TOKEN;
    data.offset = pager.getItemStart();
    data.limit = pager.getItemCount();
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
        var resourceTBody = $('#tbody_resource').empty(), html;
        for (var p in data.response.data.rows) {
            html = [];
            html.push('<tr id="', data.response.data.rows[p]['id'], '">');
            html.push('<td>');
            html.push('<img class="img-icon" src="https://www.google.co.nz/imgres?imgurl=http%3A%2F%2F2.bp.blogspot.com%2F--FAn2oUtH_Y%2FVaVDZ89gFfI%2FAAAAAAAAJsA%2Fh6F_ReTbWLI%2Fs1600%2Fa-cute-lovely-birds-images.jpg&imgrefurl=http%3A%2F%2Floving2you.blogspot.com%2F2013%2F09%2Fbeautiful-nice-and-lovely-birds-images.html&docid=LcFwFUx6EaIBDM&tbnid=1yIUkD83FB7pmM%3A&vet=10ahUKEwiRtZyyz7_WAhVBllQKHX5QCvsQMwg2KBEwEQ..i&w=1600&h=900&client=firefox-b-ab&bih=711&biw=1373&q=lovely&ved=0ahUKEwiRtZyyz7_WAhVBllQKHX5QCvsQMwg2KBEwEQ&iact=mrc&uact=8">');
            html.push('</td>');
            html.push('<td>', data.response.data.rows[p]['description'], '</td>');
            html.push('<td>', data.response.data.rows[p]['produce_time'], '</td>');
            html.push('<td>');
            html.push('<button class="btn btn-sm btn-primary" style="display: inline-block;" fire="edit">');
            html.push('<i class="fa fa-remove" aria-hidden="true"></i>');
            html.push('<span class="tbl-col-buttons-text">&nbsp;Edit</span>');
            html.push('</button>');
            html.push('<button class="btn btn-sm btn-danger right" style="display: inline-block;" fire="delete">');
            html.push('<i class="fa fa-pencil" aria-hidden="true"></i>');
            html.push('<span class="tbl-col-buttons-text">&nbsp;Delete</span>');
            html.push('</button>');
            html.push('</td>');
            html.push('</tr>');
            $(html.join('')).data(data.response.data.rows[p]).appendTo(resourceTBody);
        }
        attachResourceEvent();
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

        mibo.util.loading.hide();
    }).fail(function () {
        mibo.util.system.error();
    });
}

function attachResourceEvent() {
    $('#tbody_resource tr').each(function () {
        var $tr = $(this);
        $tr.find('button').each(function () {
            var $button = $(this);
            $button.click(function (e) {
                if ($button.attr('fire') == 'edit') {
                    console.log('edit..');
                    $('#resource_dialog').modal({
                        'backdrop': 'static',
                        'show': false
                    });
                    var editData = $tr.data();
                    $('#resource_dialog').removeData('mode').removeData('label').removeData('data').data({
                        'mode': 'edit',
                        'label': 'Edit',
                        'data': {
                            'id': editData.id,
                            'videoLink': editData.video_link,
                            'posterLink': editData.poster_link,
                            'name': editData.name,
                            'description': editData.description,
                            'author': editData.author,
                            'venue': editData.venue
                        }
                    });
                    modalInit();
                    $('#resource_dialog').modal('show');

                } else if ($button.attr('fire') == 'delete') {
                    var cb_delete = function () {
                        mibo.util.loading.show();
                        var data = data || {};
                        data.token = data.token || mibo.config.TOKEN;
                        data.id = $tr.data().id;
                        var ajp = mibo.util.http.post(mibo.config.API + 'resource/remove', data);
                        mibo.promiseq.admin_user_login = ajp;
                        ajp.done(function (data, status, ajXhr) {
                            console.log('data', data);
                            mibo.util.loading.hide();
                            if (data.response.status != 'success') {
                                mibo.util.system.error(data.response.message);
                                return;
                            }
                            fetchResources();
                        }).fail(function () {
                            mibo.util.system.error();
                        });
                    };
                    showConfirmDialog('Are you sure to delete?', cb_delete);
                }
            });
        });
    });
}

function attachEvent() {
    // Logout link
    $('#link_logout').click(function (e) {
        mibo.util.loading.show();
        var data = data || {};
        data.token = data.token || mibo.config.TOKEN;
        var ajp = mibo.util.http.post(mibo.config.API + 'user/logout', data);
        mibo.promiseq.admin_user_login = ajp;
        ajp.done(function (data, status, ajXhr) {
            console.log('data', data);
            // Construct resource tbody
            if (data.response.status != 'success') {
                mibo.util.loading.hide();
                mibo.util.system.error();
            }

            mibo.util.loading.hide();
            window.location.href = '/admin';
        }).fail(function () {
            mibo.util.system.error();
        });
    });

    // Resource add button
    $('#resource_add').click(function (e) {
        $('#resource_dialog').modal({
            'backdrop': 'static',
            'show': false
        });
        $('#resource_dialog').removeData('mode').removeData('label').removeData('data').data({
            'mode': 'add',
            'label': 'Add'
        });
        modalInit();
        $('#resource_dialog').modal('show');
    });

    // Modal dialog focus
    $('#resource_dialog input').focus(function (e) {
        $('#modal-error').hide();
    });

    // Modal submit button
    $('#modal_save').click(modalSubmit);

    // Modal check video button
    $('#modal_check').click(modalCheckVideo);

    // Pagination buttons
    $('#page_previous a').click(function (e) {
        if (!pager.isFirstPage()) {
            pager.setPage(pager.getPage() - 1);
            fetchResources();
        }
    });
    $('#page_next a').click(function (e) {
        if (!pager.isLastPage()) {
            pager.setPage(pager.getPage() + 1);
            console.log('target page: ', pager.getPage());
            fetchResources();
        }
    });
    $('#page_go').click(function (e) {
        var pageNumber = ~~$('#page_number').val();
        if (pageNumber  == 0 || pageNumber > pager.getTotalPage()) {
            mibo.util.system.error('Please input an page number between 1 and ' + pager.getTotalPage());
            return;
        }
        pager.setPage(pageNumber);
        fetchResources();
    });
}

// Modal dialog initialize
function modalInit() {
    var data = $('#resource_dialog').data();
    $('#resource_dialog .modal-title').html(data['label']);
    if (data['mode'] == 'add') {
        // For add mode
        $('#resource_dialog input').val('');
    } else if (data['mode'] == 'edit') {
        // For edit mode
        [
            {'key': 'videoLink', 'label': 'ipt_v_url'}, {'key': 'posterLink', 'label': 'ipt_i_url'}, {
            'key': 'name',
            'label': 'ipt_name'
        },
            {'key': 'description', 'label': 'ipt_description'}, {'key': 'author', 'label': 'ipt_author'}, {
            'key': 'venue',
            'label': 'ipt_venue'
        }].forEach(function (object) {
            data['data'][object['key']] && $('#' + object['label']).val(data['data'][object['key']]);
        });
    }
}
// Modal dialog submit
function modalSubmit() {
    var validate = modalValidate();
    if (validate !== true) {
        $('#modal-error').show().find('label').html(validate);
        return;
    }

    var cb_add_edit_yes = function () {
        //$('#resource_dialog').modal({'backdrop':'static'});
        var mode = $('#resource_dialog').data('mode'), data = $('#resource_dialog').data('data') || {}, url;
        if (mode == 'add') {
            url = mibo.config.API + 'resource/add';
        } else if (mode == 'edit') {
            url = mibo.config.API + 'resource/edit';
        }
        // Save resource via api
        mibo.util.loading.show();
        data.token = data.token || mibo.config.TOKEN;
        data.videoLink = $('#ipt_v_url').val();
        data.posterLink = $('#ipt_i_url').val();
        data.name = $('#ipt_name').val();
        data.description = $('#ipt_description').val();
        data.author = $('#ipt_author').val();
        data.venue = $('#ipt_venue').val();
        var ajp = mibo.util.http.post(url, data);
        mibo.promiseq.admin_user_login = ajp;
        ajp.done(function (data, status, ajXhr) {
            console.log('data', data);
            // Construct resource tbody
            if (data.response.status != 'success') {
                mibo.util.loading.hide();
                $('#modal-error').show().find('label').html(data.response.message);
                return;
            }

            mibo.util.loading.hide();
            $('#resource_dialog').modal('hide');
            fetchResources();
        }).fail(function () {
            mibo.util.system.error();
        });
    }, cb_add_edit_no = function () {
        $('#resource_dialog').modal({'backdrop': 'static'});
    };
    $('#resource_dialog').modal('hide');
    showConfirmDialog('Are you sure to save?', cb_add_edit_yes, cb_add_edit_no);

}

function modalValidate() {
    var video = $('#ipt_v_url').val(), image = $('#ipt_i_url').val(), name = $('#ipt_name').val(), flag = 1;
    if (video.trim() == '' || video.trim().length > mibo.modal.resource.videoLink.length()) {
        return 'Video URL cannot be empty, and the length must less than ' + mibo.modal.resource.videoLink.length() + '.';
    }
    if (image.trim() == '' || image.trim().length > mibo.modal.resource.posterLink.length()) {
        return 'Poster URL cannot be empty, and the length must less than ' + mibo.modal.resource.posterLink.length() + '.';
    }
    if (name.trim() == '' || name.trim().length > mibo.modal.resource.name.length()) {
        return 'Video name cannot be empty, and the length must less than ' + mibo.modal.resource.videoLink.length() + '.';
    }
    return true;
}

function modalCheckVideo() {
    var video = $('#ipt_v_url').val();
    if (video.trim() == '' || video.trim().length > mibo.modal.resource.videoLink.length()) {
        mibo.util.system.error('Video URL cannot be empty, and the length must less than ' + mibo.modal.resource.videoLink.length() + '.');
        return;
    }
    // Check video URL existence via api
    mibo.util.loading.show();
    var data = data || {};
    data.token = data.token || mibo.config.TOKEN;
    data.videoLink = $('#ipt_v_url').val();
    var ajp = mibo.util.http.post(mibo.config.API + 'resource/exist', data);
    mibo.promiseq.admin_user_login = ajp;
    ajp.done(function (data, status, ajXhr) {
        console.log('data', data);
        mibo.util.loading.hide();
        if (data.response.status != 'success') {
            $('#modal-error').show().find('label').html(data.response.message);
            return;
        }
        var message = data.response.data.exist ? 'The video URL has existed, please try another one.' : '<span class="text-success">The video URL do NOT exist, can continue to add.</span>';
        $('#modal-error').show().find('label').html(message);
    }).fail(function () {
        mibo.util.system.error();
    });
}

// Confirm dialog
function showConfirmDialog(message, cbYes, cbNo) {
    $('#confirm_dialog').modal({'backdrop': 'static', 'show': false});
    $('#confirm_dialog .modal-body label').html(message);
    $('#confirm_yes').click(function (e) {
        $('#confirm_dialog').modal('hide');
        $('#modal-error').hide();
        cbYes && cbYes();
    });
    $('#confirm_no').click(function (e) {
        $('#confirm_dialog').modal('hide');
        cbNo && cbNo();
    });
    $('#confirm_dialog').on('hide.bs.modal', function (e) {
        $('#confirm_yes').off();
        $('#confirm_no').off();
    }).modal('show');
}
