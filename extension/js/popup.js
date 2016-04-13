$(function () {
});

getJson(json => {
    translate();
    init(json);
});

function init(json) {
    if (json.status === 'success') {
        var onlineUsers = $('#online')[0];
        var updated = $('#updated')[0];
        var connectionList = $('#connectionList')[0];
        var tooltips = $('#tooltips')[0];
        var users = json.users.length;
        onlineUsers.innerText = (users < 2) ? chrome.i18n.getMessage("onlineUser", [users]) : chrome.i18n.getMessage("onlineUsers", [users]);
        updated.innerText = json.updated;

        for (var i = 0; i < json.users.length; i++) {
            var user = json.users[i];
            var tr = $('<tr></tr>');
            tr.append('<td>' + user.CommonName + '</td>');
            tr.append('<td>' + user.RealAddress + '</td>');
            tr.append('<td>' + user.BytesReceived + '</td>');
            tr.append('<td>' + user.BytesSent + '</td>');
            tr.append('<td>' + user.VirtualAddress + '</td>');
            tr.append('<td>' + user.Since + '</td>');
            $(connectionList).append(tr);
        }
    }
    else {
        //error
    }
}

function getJson(callback) {
    $.get('http://62.210.236.193/api/openvpn/index.php', {key: 'l4l4l4l4'}, json => {
        callback(json);
    });
}

function translate() {
    $('[data-resource]').each(function () {
        var el = $(this);
        var resourceName = el.data('resource');
        var resourceText = chrome.i18n.getMessage(resourceName);
        el.text(resourceText);
    });
}

function resizePopup() {
    $('html').height($('#main').height());
}