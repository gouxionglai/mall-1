if (typeof wx === 'undefined') var wx = getApp().hj;
function formatTime(date) {
    var year = date.getFullYear()
    var month = date.getMonth() + 1
    var day = date.getDate()

    var hour = date.getHours()
    var minute = date.getMinutes()
    var second = date.getSeconds()


    return [year, month, day].map(formatNumber).join('/') + ' ' + [hour, minute, second].map(formatNumber).join(':')
}

function formatData(date) {
    var year = date.getFullYear()
    var month = date.getMonth() + 1
    var day = date.getDate()

    var hour = date.getHours()
    var minute = date.getMinutes()
    var second = date.getSeconds()


    return [year, month, day].map(formatNumber).join('-');
}

function formatNumber(n) {
    n = n.toString()
    return n[1] ? n : '0' + n
}

function objectToUrlParams(obj) {
    var str = "";
    for (var key in obj) {
        str += "&" + key + "=" + obj[key];
    }
    return str.substr(1);
}

function inArray(val, arr) {
    return arr.some(function (v) {
        return val === v;
    })
}

module.exports = {
    formatTime: formatTime,
    objectToUrlParams: objectToUrlParams,
    formatData: formatData,
    inArray: inArray,
    scene_decode: function (scene) {
        var _str = scene + "";
        var _str_list = _str.split(",");
        var res = {};
        for (var i in _str_list) {
            var _tmp_str = _str_list[i];
            var _tmp_str_list = _tmp_str.split(":");
            if (_tmp_str_list.length > 0 && _tmp_str_list[0]) {
                res[_tmp_str_list[0]] = _tmp_str_list[1] || null;
            }
        }
        return res;
    },
};