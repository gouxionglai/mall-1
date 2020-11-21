if (typeof wx === 'undefined') var wx = getApp().core;
var utils = require('../../../utils/helper.js');
var is_loading = false;
var is_no_more = false;
Page({

    /**
     * 页面的初始数据
     */
    data: {
        page: 1,
        page_count: 1,
        longitude: '',
        latitude: '',
        score: [1, 2, 3, 4, 5],
        keyword: ''
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) { getApp().page.onLoad(this, options);
        var self = this;
        self.setData({
            ids: options.ids,
        });
        getApp().core.getLocation({
            success: function (res) {
                self.setData({
                    longitude: res.longitude,
                    latitude: res.latitude
                });
            },
            complete: function () {
                self.loadData();
            }
        })
    },

    /**
     * 生命周期函数--监听页面初次渲染完成
     */
    onReady: function (options) { getApp().page.onReady(this);

    },

    /**
     * 生命周期函数--监听页面显示
     */
    onShow: function (options) { getApp().page.onShow(this);
        var self = this;
    },
    loadData: function () {
        var self = this;
        getApp().core.showLoading({
            title: '加载中',
        });
        getApp().request({
            url: getApp().api.book.shop_list,
            method: 'GET',
            data: {
                longitude: self.data.longitude,
                latitude: self.data.latitude,
                ids: self.data.ids,
            },
            success: function (res) {
                if (res.code == 0) {
                    self.setData(res.data);
                }
            },
            fail:function(res){
            },
            complete: function () {
                getApp().core.hideLoading();
            }

        });
    },

    /**
     * 生命周期函数--监听页面隐藏
     */
    onHide: function (options) { getApp().page.onHide(this);

    },

    /**
     * 生命周期函数--监听页面卸载
     */
    onUnload: function (options) { getApp().page.onUnload(this);

    },

    /**
     * 页面相关事件处理函数--监听用户下拉动作
     */
    onPullDownRefresh: function (options) { getApp().page.onPullDownRefresh(this);
        var self = this;
        self.setData({
            keyword: '',
            page: 1
        });
        getApp().core.getLocation({
            success: function (res) {
                self.setData({
                    longitude: res.longitude,
                    latitude: res.latitude
                });
            },
            complete: function () {
                self.loadData();
                getApp().core.stopPullDownRefresh();
            }
        })
    },

    /**
     * 页面上拉触底事件的处理函数
     */
    onReachBottom: function (options) { getApp().page.onReachBottom(this);
        var self = this;
        if (self.data.page >= self.data.page_count) {
            return;
        }
        self.loadMoreData();
    },

    loadMoreData: function () {
        var self = this;
        var p = self.data.page;
        if (is_loading) {
            return;
        }
        is_loading = true;
        getApp().core.showLoading({
            title: '加载中',
        });
        getApp().request({
            url: getApp().api.book.shop_list,
            method: 'GET',
            data: {
                page: p,
                longitude: self.data.longitude,
                latitude: self.data.latitude,
                ids: self.data.ids,
            },
            success: function (res) {
                if (res.code == 0) {
                    var shop_list = self.data.list.concat(res.data.list);
                    self.setData({
                        list: shop_list,
                        page_count: res.data.page_count,
                        row_count: res.data.row_count,
                        page: (p + 1)
                    });
                }
            },
            complete: function () {
                getApp().core.hideLoading();
                is_loading = false;
            }
        });
    },

    goto: function (e) {
        var self = this;
        if (typeof my !== 'undefined') {
            self.location(e);
        } else {
            getApp().core.getSetting({
                success: function (res) {
                    if (!res.authSetting['scope.userLocation']) {
                        getApp().getauth({
                            content: '需要获取您的地理位置授权，请到小程序设置中打开授权！',
                            cancel: false,
                            author: 'scope.userLocation',
                            success: function (res) {
                                if (res.authSetting['scope.userLocation']) {
                                    self.location(e);
                                }
                            }
                        });
                    } else {
                        self.location(e);
                    }
                }
            })
        }
    },

    location: function (e) {
        var self = this;
        var index = e.currentTarget.dataset.index;
        var shop_list = self.data.list;
        getApp().core.openLocation({
            latitude: parseFloat(shop_list[index].latitude),
            longitude: parseFloat(shop_list[index].longitude),
            name: shop_list[index].name,
            address: shop_list[index].address,
        })
    },

    inputFocus: function (e) {
        this.setData({
            show: true
        });
    },

    inputBlur: function (e) {
        this.setData({
            show: false
        });
    },

    inputConfirm: function (e) {
        var self = this;
        self.search();
    },

    input: function (e) {
        var self = this;
        self.setData({
            keyword: e.detail.value
        });
    },

    search: function (e) {
        var self = this;
        getApp().core.showLoading({
            title: '搜索中',
        });
        getApp().request({
            url: getApp().api.book.shop_list,
            method: 'GET',
            data: {
                keyword: self.data.keyword,
                longitude: self.data.longitude,
                latitude: self.data.latitude,
                ids: self.data.ids,
            },
            success: function (res) {
                if (res.code == 0) {
                    self.setData(res.data);
                }
            },
            complete: function () {
                getApp().core.hideLoading();
            }
        });
    },

    go: function (e) {
        var self = this;
        var index = e.currentTarget.dataset.index;
        var shop_list = self.data.list;
        getApp().core.navigateTo({
            url: '/pages/shop-detail/shop-detail?shop_id=' + shop_list[index].id,
        })
    },

    navigatorClick: function (e) {
        var self = this;
        var open_type = e.currentTarget.dataset.open_type;
        var url = e.currentTarget.dataset.url;
        if (open_type != 'wxapp')
            return true;
        url = parseQueryString(url);
        url.path = url.path ? decodeURIComponent(url.path) : "";
        getApp().core.navigateToMiniProgram({
            appId: url.appId,
            path: url.path,
            complete: function (e) {
            }
        });
        return false;

        function parseQueryString(url) {
            var reg_url = /^[^\?]+\?([\w\W]+)$/,
                reg_para = /([^&=]+)=([\w\W]*?)(&|$|#)/g,
                arr_url = reg_url.exec(url),
                ret = {};
            if (arr_url && arr_url[1]) {
                var str_para = arr_url[1], result;
                while ((result = reg_para.exec(str_para)) != null) {
                    ret[result[1]] = result[2];
                }
            }
            return ret;
        }
    },
})