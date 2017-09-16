exports.install = function (Vue, options) {
    Vue.prototype.formatSeconds = function (value) {
        var theTime = parseInt(value);// 秒 
        var theTime1 = 0;// 分 
        var theTime2 = 0;// 小时 
        // alert(theTime); 
        if (theTime > 60) {
            theTime1 = parseInt(theTime / 60);
            theTime = parseInt(theTime % 60);
            // alert(theTime1+"-"+theTime); 
            if (theTime1 > 60) {
                theTime2 = parseInt(theTime1 / 60);
                theTime1 = parseInt(theTime1 % 60);
            }
        }
        var timeArr = [];
        if (theTime > 0) {
            timeArr[2] = theTime >= 10 ? parseInt(theTime) : '0' + String(theTime);
        } else {
            timeArr[2] = '00';
        }
        if (theTime1 > 0) {
            timeArr[1] = theTime1 >= 10 ? parseInt(theTime1) : '0' + String(theTime1);
        } else {
            timeArr[1] = '00';
        }
        if (theTime2 > 0) {
            timeArr[0] = theTime2 >= 10 ? parseInt(theTime2) : '0' + String(theTime2);
        } else {
            timeArr[0] = '00';
        }
        return timeArr.join(':');
    }

    //将 get 数据进行转换
    Vue.prototype.getDataFormat = function(value){
        let  getData = [];
        for(let i in value){
            getData.push(i+'='+value[i])
        }
        return getData.join('&');
    }
}