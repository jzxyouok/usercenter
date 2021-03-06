$(function(){
//给默认焦点
$("#tele").focus();
$('.telephone').focus(function(){
	$(this).addClass('focus');
});
$('.telephone').blur(function(){
	$(this).removeClass('focus');
});
$(".verificatCode").focus(function(){
	$(this).addClass('focus');
});
$('.verificatCode').blur(function(){
	$(this).removeClass('focus');
});
$("#login").click(function(){
    var loginaccount= $('#signin-username');
    var verify = $('#signin-password').val(); //验证码
	if(loginaccount.val()==""){
        loginaccount.focus();
        ship_mess_big('手机号不能为空');
		return false;
	}
    var reg = /^1[3|4|5|7|8]\d{9}$/;;
    if(!reg.test($.trim(loginaccount.val()))){
        loginaccount.focus();
        ship_mess_big('请填写正确的手机号');
        return false;
    }

    //验证码不能为空
    if(verify.trim() == ''){
        $('#signin-password').focus();
        ship_mess_big('验证码不能为空');
        return false;
    }
    //判断验证码是否正确
    $.ajax({
        url:'/member/verifyMsg',
        data:{mobile:loginaccount.val(),param:verify},
        dataType:'json',
        type:'post',
        success: function (data) {
            if(data.status == 'n'){
                $('#signin-password').focus();
                ship_mess_big(data.info);
                return false;
            }
        }

    });
//	if(loginpassword.val()=="" || loginpassword.val().length<6 || loginpassword.val().length>16){
//		UI.popup({
//			type:1,
//			html:'密码不能为空并且不能小于8位和大于16位'
//		});
//		return false;
//	}
    var appid = $('#appid').val();
    var appkey = $('#appkey').val();
    var openid = $('#openid').val();
	var account = loginaccount.val();
	//var password = loginpassword.val();
    var return_url = $('#return_url').val();
    //报名专用
    var sid = '';
    sid = $('#sid').val();
    var action = '';
    action = $('#action').val();

    var hidd = '';
        hidd = $('#hidd').val();
	var rember = 1;
    //console.log(return_url);
	if($('#remember-me').is(':checked')) {

        }else{
            if(hidd){
                rember = 0;
            }

	}
    //console.log(action);
    //alert(rember);
    //return false;
	$.ajax({
		url:'/member/wapAjaxlogin',
		data:{appid:appid,appkey:appkey,openid:openid,account:account,verify:verify,rember:rember,return_url:return_url,sid:sid,action:action},
		dataType:'json',
		type:'post',
		success : function(data){
                        if(data.state == 1){
                            ship_mess_big(data.message);
                            setTimeout(function(){
                                //location.reload();
                                // $('.cd-user-modal-container').hide();
                              window.location.href = data.return_url;
                            },600);
			}else{
                            ship_mess_big(data.message);
			}
		}
	});
});


//验证码
var star = true;
var yzm = null;
//注册
$("#zhuce").click(function(){
    regone();
});
function regone(){
	//var regusername = $("#username");
    var regusername = $("#signup-username");
    if(regusername.val()==""){
        ship_mess_big('手机号码不能为空');
        return false;
    }else{
        var reg = /^1[3|5|8]\d{9}$/;
        var val = regusername.val();
        if(reg.test(val)==false){
            ship_mess_big('请输入正确的电话号码格式');
            return false;
        }
    }
    if($("#verify").val()==""){
        ship_mess_big('图片验证码不能为空');
        return false;
    }
    var appid = $('#appid').val();
    var appkey = $('#appkey').val();
    var openid = $('#openid').val();
	var account = regusername.val();
    var verify = $("#verify").val();
	//var password = $("#password").val();
    var password = $("#signup-password").val();

    //var repassword = $("#repassword").val();
	var repassword = $("#signup-repassword").val();
    //var agree=$('#agree').is(':checked');
	var agree=$('#accept-terms').is(':checked');

    if(password=="" || password.length<6 ){
        ship_mess_big('密码不能为空并且不能小于6位');
        return false;
    }
    if(repassword=="" || repassword.length<6 ){
        ship_mess_big('重复密码不能为空并且不能小于6位');
        return false;
    }
    if(password!==repassword){
        ship_mess_big('两次密码输入不一致');
        return false;
    }
    if(!agree){
        ship_mess_big('没有同意本站协议');
		return false;
    }
    //alert(mid);
    //return false;
    $.ajax({
        url : '/member/wapAjaxReg',
        data : {appid:appid,appkey:appkey,openid:openid,account:account,password:password,repassword:repassword,verify:verify,agree:agree},
        dataType : 'json',
        type : 'post',
        success : function(data){
            if(data.state==1){
                ship_mess_big(data.message);
                setTimeout(function(){
                    //window.location.href = data.login_url;
                    $('.cd-user-modal').hide();
                    ship_mess(data.message);
                },600);
                //UI.clearPopup();
            }else{
                ship_mess_big(data.message);
            }
        }
    });
}


//完善注册
$("#regtwo").click(function() {
    regtwo();

});
    function regtwo(){
        var genre= $("input[name='genre']:checked").val();
        var company= $("#company").val();
        var icon= $("#icon").val();
        var address= $("#address").val();
        var username= $("#username").val();
        var email = $("#email");
        var tel = $("#tel");

        if (tel.val() != "") {
            var reg = /^1[3|5|8]\d{9}$/;
            if (reg.test(tel.val()) == false) {
                ship_mess_big('请输入正确的电话号码格式');
                return false;
            }
        }
        if (email.val() != "") {
            var reg= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(reg.test(email.val()) == false) {
                ship_mess('请输入正确的邮箱格式');
                return false;
            }
        }

        $.ajax({
            url: Siteurl + '/member/AjaxRegTwo',
            data: {genre: genre, company: company,icon:icon, address: address, username: username, tel: tel.val(), email: email.val()},
            dataType: 'json',
            type: 'post',
            success: function (data) {
                if (data.state == 1) {
                    ship_mess_big(data.message);
                    setTimeout(function () {
                        window.location.href = data.login_url;
                    }, 600);
                    //UI.clearPopup();
                } else {
                    ship_mess_big(data.message);
                }
            }
        });
    }

});