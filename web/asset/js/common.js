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
        'post': function(url, data, headerOptions){
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
        'error': function(msg){
            var msg = msg || 'You seems to meet up a system error. It is appreciated if you can send an email to us via: rhinostudio2017@gmail.com';
            alert(msg);
        }
    },
    'pager': function(){
        function Pager() {
            var currentPage = 1, totalPage = 1, totalItem = 0, itemCount = 20, itemStart = 0;
            this.setPage = function(page){
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
            this.increasePage = function(){
                currentPage < totalPage && currentPage++;
            };
            this.decreasePage = function(){
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
    }
};

mibo.modal = mibo.modal || {
    'resource': {
        'videoLink': {
            'length': function(){
                return 64;
            }
        },
        'posterLink': {
            'length': function(){
                return 64;
            }
        },
        'name': {
            'length': function(){
                return 64;
            }
        },
        'description': {
            'length': function(){
                return 256;
            }
        },
        'author': {
            'length': function(){
                return 32;
            }
        },
        'venue': {
            'length': function(){
                return 64;
            }
        },
        'note': {
            'length': function(){
                return 128;
            }
        }
    },
    'user': {
        'username': {
            'length': function(){
                return 64;
            }
        },
        'password': {
            'length': function(){
                return 64;
            }
        },
        'email': {
            'length': function(){
                return 64;
            }
        }
    }
};