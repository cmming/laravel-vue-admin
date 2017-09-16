import Vue from 'vue'


// 将时间 秒转换为 分

Vue.filter('formatSeconds',
    function (value) {
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
        var result = "" + parseInt(theTime);
        // var result = ""+parseInt(theTime)+"秒"; 
        if (theTime1 > 0) {
            // result = ""+parseInt(theTime1)+"分"+result; 
            result = "" + parseInt(theTime1) + ":" + result;
        }
        if (theTime2 > 0) {
            // result = ""+parseInt(theTime2)+"小时"+result; 
            result = "" + parseInt(theTime2) + ":" + result;
        }
        return result;
    });

Vue.filter('user_ori_att',
    function (value) {
        var attObj = JSON.parse(value), resStr = [];
        for (var i in attObj) {
            if (i == 'be_fp') {
                resStr.push((attObj[i] == 0) ? '分屏' : '不分屏');
            }
            else if (i == 'fee') {
                resStr.push("费用为" + attObj[i] + "元");
            } else if (i == 'free_time') {
                resStr.push("免费时间为" + attObj[i]);
            }
        }
        return resStr.join(',');

    });

Vue.filter('bytesToSize',
    function (bytes) {
        if (bytes === 0) return '0 B';

        var k = 1024,

            sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],

            i = Math.floor(Math.log(bytes) / Math.log(k));

        return (bytes / Math.pow(k, i)).toPrecision(4) + ' ' + sizes[i];
        //toPrecision(3) 后面保留一位小数，如1.0GB                                                                                                                  //return (bytes / Math.pow(k, i)).toPrecision(3) + ' ' + sizes[i];  
    });