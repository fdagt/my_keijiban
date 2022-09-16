
function register_nickname(id) {
    nickname = document.getElementById(id).value;
    if (nickname !== "") {
	Cookies.set("nickname", nickname, {expires:7});
    }
}

function fill_nickname_from_cookie(id) {
    c = Cookies.get();
    if ("nickname" in c) {
	document.getElementById(id).value = c["nickname"];
    }
}
