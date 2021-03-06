/**!
 * 微信内置浏览器的Javascript API，功能包括：
 *
 * 1、分享到微信朋友圈
 * 2、分享给微信好友
 * 3、分享到腾讯微博
 * 4、新的分享接口，包含朋友圈、好友、微博的分享（for iOS）
 * 5、隐藏/显示右上角的菜单入口
 * 6、隐藏/显示底部浏览器工具栏
 * 7、获取当前的网络状态
 * 8、调起微信客户端的图片播放组件
 * 9、关闭公众平台Web页面
 * 10、判断当前网页是否在微信内置浏览器中打开
 * 11、增加打开扫描二维码
 * 12、支持WeixinApi的错误监控
 * 13、检测应用程序是否已经安装（需要官方开通权限）
 *
 * @author zhaoxianlie(http://www.baidufe.com)
 */
var WeixinApi=(function(){"use strict";function weixinShareTimeline(data,callbacks){callbacks=callbacks||{};var shareTimeline=function(theData){WeixinJSBridge.invoke('shareTimeline',{"appid":theData.appId?theData.appId:'',"img_url":theData.imgUrl,"link":theData.link,"desc":theData.title,"title":theData.desc,"img_width":"640","img_height":"640"},function(resp){switch(resp.err_msg){case'share_timeline:cancel':callbacks.cancel&&callbacks.cancel(resp);break;case'share_timeline:confirm':case'share_timeline:ok':callbacks.confirm&&callbacks.confirm(resp);break;case'share_timeline:fail':default:callbacks.fail&&callbacks.fail(resp);break;}
callbacks.all&&callbacks.all(resp);});};WeixinJSBridge.on('menu:share:timeline',function(argv){if(callbacks.async&&callbacks.ready){window["_wx_loadedCb_"]=callbacks.dataLoaded||new Function();if(window["_wx_loadedCb_"].toString().indexOf("_wx_loadedCb_")>0){window["_wx_loadedCb_"]=new Function();}
callbacks.dataLoaded=function(newData){window["_wx_loadedCb_"](newData);shareTimeline(newData);};callbacks.ready&&callbacks.ready(argv);}else{callbacks.ready&&callbacks.ready(argv);shareTimeline(data);}});}
function weixinSendAppMessage(data,callbacks){callbacks=callbacks||{};var sendAppMessage=function(theData){WeixinJSBridge.invoke('sendAppMessage',{"appid":theData.appId?theData.appId:'',"img_url":theData.imgUrl,"link":theData.link,"desc":theData.desc,"title":theData.title,"img_width":"640","img_height":"640"},function(resp){switch(resp.err_msg){case'send_app_msg:cancel':callbacks.cancel&&callbacks.cancel(resp);break;case'send_app_msg:confirm':case'send_app_msg:ok':callbacks.confirm&&callbacks.confirm(resp);break;case'send_app_msg:fail':default:callbacks.fail&&callbacks.fail(resp);break;}
callbacks.all&&callbacks.all(resp);});};WeixinJSBridge.on('menu:share:appmessage',function(argv){if(callbacks.async&&callbacks.ready){window["_wx_loadedCb_"]=callbacks.dataLoaded||new Function();if(window["_wx_loadedCb_"].toString().indexOf("_wx_loadedCb_")>0){window["_wx_loadedCb_"]=new Function();}
callbacks.dataLoaded=function(newData){window["_wx_loadedCb_"](newData);sendAppMessage(newData);};callbacks.ready&&callbacks.ready(argv);}else{callbacks.ready&&callbacks.ready(argv);sendAppMessage(data);}});}
function weixinShareWeibo(data,callbacks){callbacks=callbacks||{};var shareWeibo=function(theData){WeixinJSBridge.invoke('shareWeibo',{"content":theData.desc,"url":theData.link},function(resp){switch(resp.err_msg){case'share_weibo:cancel':callbacks.cancel&&callbacks.cancel(resp);break;case'share_weibo:confirm':case'share_weibo:ok':callbacks.confirm&&callbacks.confirm(resp);break;case'share_weibo:fail':default:callbacks.fail&&callbacks.fail(resp);break;}
callbacks.all&&callbacks.all(resp);});};WeixinJSBridge.on('menu:share:weibo',function(argv){if(callbacks.async&&callbacks.ready){window["_wx_loadedCb_"]=callbacks.dataLoaded||new Function();if(window["_wx_loadedCb_"].toString().indexOf("_wx_loadedCb_")>0){window["_wx_loadedCb_"]=new Function();}
callbacks.dataLoaded=function(newData){window["_wx_loadedCb_"](newData);shareWeibo(newData);};callbacks.ready&&callbacks.ready(argv);}else{callbacks.ready&&callbacks.ready(argv);shareWeibo(data);}});}
function weixinGeneralShare(data,callbacks){callbacks=callbacks||{};var generalShare=function(general,theData){if(general.shareTo=='timeline'){var title=theData.title;theData.title=theData.desc||title;theData.desc=title;}
general.generalShare({"appid":theData.appId?theData.appId:'',"img_url":theData.imgUrl,"link":theData.link,"desc":theData.desc,"title":theData.title,"img_width":"640","img_height":"640"},function(resp){switch(resp.err_msg){case'general_share:cancel':callbacks.cancel&&callbacks.cancel(resp,general.shareTo);break;case'general_share:confirm':case'general_share:ok':callbacks.confirm&&callbacks.confirm(resp,general.shareTo);break;case'general_share:fail':default:callbacks.fail&&callbacks.fail(resp,general.shareTo);break;}
callbacks.all&&callbacks.all(resp,general.shareTo);});};WeixinJSBridge.on('menu:general:share',function(general){if(callbacks.async&&callbacks.ready){window["_wx_loadedCb_"]=callbacks.dataLoaded||new Function();if(window["_wx_loadedCb_"].toString().indexOf("_wx_loadedCb_")>0){window["_wx_loadedCb_"]=new Function();}
callbacks.dataLoaded=function(newData){window["_wx_loadedCb_"](newData);generalShare(general,newData);};callbacks.ready&&callbacks.ready(general,general.shareTo);}else{callbacks.ready&&callbacks.ready(general,general.shareTo);generalShare(general,data);}});}
function addContact(appWeixinId,callbacks){callbacks=callbacks||{};WeixinJSBridge.invoke("addContact",{webtype:"1",username:appWeixinId},function(resp){var success=!resp.err_msg||"add_contact:ok"==resp.err_msg||"add_contact:added"==resp.err_msg;if(success){callbacks.success&&callbacks.success(resp);}else{callbacks.fail&&callbacks.fail(resp);}})}
function imagePreview(curSrc,srcList){if(!curSrc||!srcList||srcList.length==0){return;}
WeixinJSBridge.invoke('imagePreview',{'current':curSrc,'urls':srcList});}
function showOptionMenu(){WeixinJSBridge.call('showOptionMenu');}
function hideOptionMenu(){WeixinJSBridge.call('hideOptionMenu');}
function showToolbar(){WeixinJSBridge.call('showToolbar');}
function hideToolbar(){WeixinJSBridge.call('hideToolbar');}
function getNetworkType(callback){if(callback&&typeof callback=='function'){WeixinJSBridge.invoke('getNetworkType',{},function(e){callback(e.err_msg);});}}
function closeWindow(callbacks){callbacks=callbacks||{};WeixinJSBridge.invoke("closeWindow",{},function(resp){switch(resp.err_msg){case'close_window:ok':callbacks.success&&callbacks.success(resp);break;default:callbacks.fail&&callbacks.fail(resp);break;}});}
function wxJsBridgeReady(readyCallback){if(readyCallback&&typeof readyCallback=='function'){var Api=this;var wxReadyFunc=function(){readyCallback(Api);};if(typeof window.WeixinJSBridge=="undefined"){if(document.addEventListener){document.addEventListener('WeixinJSBridgeReady',wxReadyFunc,false);}else if(document.attachEvent){document.attachEvent('WeixinJSBridgeReady',wxReadyFunc);document.attachEvent('onWeixinJSBridgeReady',wxReadyFunc);}}else{wxReadyFunc();}}}
function openInWeixin(){return/MicroMessenger/i.test(navigator.userAgent);}
function scanQRCode(callbacks){callbacks=callbacks||{};WeixinJSBridge.invoke("scanQRCode",{},function(resp){switch(resp.err_msg){case'scan_qrcode:ok':callbacks.success&&callbacks.success(resp);break;default:callbacks.fail&&callbacks.fail(resp);break;}});}
function getInstallState(data,callbacks){callbacks=callbacks||{};WeixinJSBridge.invoke("getInstallState",{"packageUrl":data.packageUrl||"","packageName":data.packageName||""},function(resp){var msg=resp.err_msg,match=msg.match(/state:yes_?(.*)$/);if(match){resp.version=match[1]||"";callbacks.success&&callbacks.success(resp);}else{callbacks.fail&&callbacks.fail(resp);}
callbacks.all&&callbacks.all(resp);});}
function enableDebugMode(callback){window.onerror=function(errorMessage,scriptURI,lineNumber,columnNumber){if(typeof callback==='function'){callback({message:errorMessage,script:scriptURI,line:lineNumber,column:columnNumber});}else{var msgs=[];msgs.push("额，代码有错。。。");msgs.push("\n错误信息：",errorMessage);msgs.push("\n出错文件：",scriptURI);msgs.push("\n出错位置：",lineNumber+'行，'+columnNumber+'列');alert(msgs.join(''));}}}
return{version:"2.5",enableDebugMode:enableDebugMode,ready:wxJsBridgeReady,shareToTimeline:weixinShareTimeline,shareToWeibo:weixinShareWeibo,shareToFriend:weixinSendAppMessage,generalShare:weixinGeneralShare,addContact:addContact,showOptionMenu:showOptionMenu,hideOptionMenu:hideOptionMenu,showToolbar:showToolbar,hideToolbar:hideToolbar,getNetworkType:getNetworkType,imagePreview:imagePreview,closeWindow:closeWindow,openInWeixin:openInWeixin,getInstallState:getInstallState,scanQRCode:scanQRCode};})();
