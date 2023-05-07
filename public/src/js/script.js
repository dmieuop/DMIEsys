function submitFunction() {
    document.getElementById("progressbar").classList.remove("hidden")
    document.getElementById("submit").classList.add("btn-blue-disabled")
}

//nav bar toggle
var menu = document.getElementById("profile-dropdown-menu");
document.getElementById('profile-dropdown-button').addEventListener('click', showMenu);
document.getElementById('main').addEventListener('click', hideMenu);
function showMenu() {
    menu.classList.toggle('hidden');
}
function hideMenu() {
    menu.classList.add('hidden');
}

function playNotificationSound() {
    document.getElementById("notification_sound").play();
    window.livewire.emit('updateNotificationBadge');
}

function playMessageSound() {
    document.getElementById("message_sound").play();
}

function playSentSound() {
    document.getElementById("sent_sound").play();
}

// Auto reload widgets
setInterval(function () {
    window.livewire.emitTo('messages-indicator', 'updateMessageIndicator');
    window.livewire.emitTo('instant-notification', 'showInstantNotification');
}, 10000);
