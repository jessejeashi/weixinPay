
// $(document).ready(function(){
// 	$('#btn_purchase').click(function(){
// 		on_purchase();
// 	});
// });

// function on_purchase(){
// 	alert("hello");
// }

require("../css/style.css");
var $ = require("./jquery-3.1.0.js");
require("./avalon.js");


avalon.ready(function() {
// 	var vm = avalon.define({
//    $id: "test",
//    id:"",
//    banner_pic:""
//    // aaa: "", //这里应该把所有AJAX都返回的数据都定义好
//    // bbb: ""
// });

	// $.ajax({
 //     url: "http://54.238.151.99/tests/test.php",
 //     dataType: "jsonp",
 //     data: JSON.parse(JSON.stringify(vm.$model)), //去掉数据模型中的所有函数
 //     success: function(ajaxData) {
 //         //需要自己在这里定义一个函数,将缺少的属性补上,无用的数据去掉，
 //         //格式不正确的数据转换好 ajaxData最后必须为一个对象
 //         console.log(ajaxData);
 //         ajaxData = filterData(ajaxData);
 //         //先已有的数据，新的数据，全部拷贝到一个全新的空对象中，再赋值，防止影响原来的$model
 //         var newData = avalon.mix(true, {}, vm.$model, ajaxData);
 //         console.log(newData);
 //         for (var i in newData) {
 //             if (vm.hasOwnProperty(i) && i !== "hasOwnProperty"){//安全更新数据
 //                 vm[i] = newData[i];
 //                 console.log(vm[i]);
 //             }
 //         }
 //     }
 // });


	var vm = avalon.define({
		$id: "goods_container",
		status:"",
		id:"",
		banner_pic:"",
		item_logo:"",
		bottom_pic:"",
		item_des: "",
		currency: "",
		item_price: "",
		goods_title: "",
		goods_detail: "",
		bottom_left:"",
		bottom_right:"",
		
		on_purchase: function(){
			window.location.href='https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe1b0f22089fadce1&redirect_uri=http%3A%2F%2F535b91df.ngrok.natapp.cn%2Flumentest%2Flumenproject%2Fpublic%2Fjsapi&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect';
		}

	});

    $.ajax({  //这里会发出两次请来
      async:false,
      type: "get",
      url: "http://54.238.151.99/lumentest/lumenproject/public/getgoods?id="+"1",
      dataType: "json",
      success: function(data){
          console.log(data)
          avalon.mix(vm, data)
      }
   })
	
	avalon.scan();

})