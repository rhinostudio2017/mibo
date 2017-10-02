/*
 * Global settings
 * */
var mibo = mibo || {};

// Config
mibo.config = mibo.config || {
        'API': $('#api').val() || '',
        'TOKEN': $('#token').val() || '',
        'loading': {
            'id': '#loading_panel'
        }
    };

// Promise queue
mibo.promiseq = mibo.promiseq || {};

// Util
mibo.util = mibo.util || {
        'loading': {
            'show': function () {
                $(mibo.config.loading.id).show();
            },
            'hide': function () {
                $(mibo.config.loading.id).hide();
            }
        },
        'http': {
            'post': function (url, data, headerOptions) {
                return $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    dataType: 'json',
                    headers: headerOptions || {}
                });
            }
        },
        'system': {
            'error': function (msg) {
                var msg = msg || 'You seems to meet up a system error. It is appreciated if you can send an email to us via: rhinostudio2017@gmail.com';
                alert(msg);
            }
        },
        'format': {
            'number2kview': function (number) {
                var strNumber = number + '', strLength = strNumber.length;
                if (strLength <= 3) {
                    return number;
                }
                var strView = '', start = 3, end;
                strView = ',' + strNumber.slice(-start);
                while (start < strLength) {
                    end = -start;
                    start += 3;
                    if (start > strLength) {
                        start = strLength;
                    }
                    strView = ',' + strNumber.slice(-start, end) + strView;
                }
                strView = strView.slice(1);
                return strView;
            }
        },
        'pager': function () {
            function Pager() {
                var currentPage = 1, totalPage = 1, totalItem = 0, itemCount = 10, itemStart = 0;
                this.setPage = function (page) {
                    currentPage = page;
                };
                this.getPage = function () {
                    return currentPage;
                };
                this.setTotalPage = function (pageCount) {
                    totalPage = pageCount;
                };
                this.getTotalPage = function () {
                    return totalPage;
                };
                this.increasePage = function () {
                    currentPage < totalPage && currentPage++;
                };
                this.decreasePage = function () {
                    currentPage > 1 && currentPage--;
                };
                this.isFirstPage = function () {
                    return currentPage == 1;
                }
                this.isLastPage = function () {
                    return currentPage == totalPage;
                }
                this.setItemCount = function (count) {
                    itemCount = count;
                }
                this.getItemCount = function () {
                    return itemCount;
                }
                this.setTotalItem = function (itemNumber) {
                    totalItem = itemNumber;
                    this.setTotalPage(Math.floor(totalItem / itemCount) + 1);
                }
                this.getItemStart = function () {
                    return (currentPage - 1) * itemCount;
                }
            }

            return new Pager();
        },
        'form': {
            'post': function (url, data) {
                var form = document.createElement('form');
                form.target = '_blank';
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                for (var key in data) {
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        }
    };

mibo.modal = mibo.modal || {
        'resource': {
            'videoLink': {
                'length': function () {
                    return 128;
                }
            },
            'posterLink': {
                'length': function () {
                    return 64;
                }
            },
            'name': {
                'length': function () {
                    return 64;
                }
            },
            'description': {
                'length': function () {
                    return 256;
                }
            },
            'author': {
                'length': function () {
                    return 32;
                }
            },
            'venue': {
                'length': function () {
                    return 64;
                }
            },
            'note': {
                'length': function () {
                    return 128;
                }
            }
        },
        'user': {
            'username': {
                'length': function () {
                    return 64;
                }
            },
            'password': {
                'length': function () {
                    return 64;
                }
            },
            'email': {
                'length': function () {
                    return 64;
                }
            }
        }
    };

/*
 * Common initialization
 * */
/*
 (function () {
 // Stiky footer
 console.log(window.screen.availHeight, $('.page').height(), $('.div-footer').height(), 'loading..');
 $(window).load(function () {
 console.log(window.screen.availHeight, $('.page').height(), $('.div-footer').height());
 if ($('.page').height() < window.screen.availHeight - $('.div-footer').height() - 56) {
 $('.div-footer').hasClass('div-footer-fixed') && $('.div-footer').addClass('div-footer-fixed');
 } else {
 $('.div-footer').hasClass('div-footer-fixed') && $('.div-footer').removeClass('div-footer-fixed');
 }
 });
 })();
 */
// Stiky footer
function stikyFooter() {
    if ($('.page').height() < window.screen.availHeight - $('.div-footer').height() - 56) {
        !$('.div-footer').hasClass('div-footer-fixed') && $('.div-footer').addClass('div-footer-fixed');
    } else {
        $('.div-footer').hasClass('div-footer-fixed') && $('.div-footer').removeClass('div-footer-fixed');
    }
}

$(window).bind('load', stikyFooter);

// Search form
$('#form_search').submit(function (e) {
    e.preventDefault();
    /*
    var keyword = $('#search_text').val();
    if (!keyword.trim()) {
        return;
    }
    */
    var page = $('#page').val();
    if (page == 'admin') {
         typeof admin_fetchResources == 'function' && admin_fetchResources();
    } else if (page == 'search') {
        $('#keyword').val($('#search_text').val());
        typeof pager == 'object' && pager.setPage(1);
        typeof search_searchResources == 'function' && search_searchResources();
    } else {
        var data = {}, url = '/search';
        data.keyword = keyword;
        mibo.util.form.post(url, data);
    }

});