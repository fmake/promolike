
function doLoginVK() {
  VK.Auth.login(
    null,
    VK.access.FRIENDS | VK.access.WIKI
  );
}
function doLogout() {
  VK.Auth.logout(logoutOpenAPI);
}
function loginOpenAPI() {
  document.getElementById('button_vk').style.display = 'none';
  document.getElementById('login_vk').style.display = 'block';
  getInitData();
}
function logoutOpenAPI() {
  /*window.location.reload();*/
  window.location = document.location;
}
function getInitData() {
  var code;
  code = 'return {';
  code += 'me: API.getProfiles({uids: API.getVariable({key: 1280}), fields: "photo"})[0]';
  //code += ',info: API.getGroupsFull({gids:1})[0]';
  //code += ',news: API.pages.get({gid:1, pid: 2424933, need_html: 1})';
  //code += ',friends: API.getProfiles({uids: API.getAppFriends(), fields: "photo"})';
  code += ',friends: API.friends.get({fields: "uid,photo,nickname"})';
  code += ',wall: API.wall.get()';
  code += '};';
  VK.Api.call('execute', {'code': code}, onGetInitData);
}
function onGetInitData(data) {
  var r, i, j, html;
  if (data.response) {
    r = data.response;
    /* Insert user info */
    if (r.me) {
      $('#openapi_user').html(r.me.first_name + ' ' + r.me.last_name);
      $('#openapi_userlink').attr('href','http://vkontakte.ru/id' + r.me.uid);
      $('#openapi_userphoto').attr('src',r.me.photo);
    }
	if(r.friends){
		$('#size_friends').html(r.friends.length);
	}
	if(r.wall){
		$('#size_messages_wall').html(r.wall.length);
	}
  }
	function sendWallMessage(){
		var code;
		code = 'return {';
		code += ',wall: API.wall.savePost({wall_id: API.getVariable({key: 1280}),message: "test messages"})';
		code += '};';
		VK.Api.call('execute', {'code': code});
	}
}