const dark_mode_btn = document.getElementById('dark-mode-icon');

/**
 * The function sets a cookie with a given name, value, and expiration date.
 * @param cookieName - The name of the cookie you want to set. This is a string value.
 * @param cookieValue - The value that you want to store in the cookie. It can be a string, number, or
 * any other valid JavaScript data type.
 * @param expiryDays - The `expiryDays` parameter is the number of days after which the cookie will
 * expire. It is used to calculate the expiry date of the cookie by adding the number of days to the
 * current date.
 */
function setCookie(cookieName, cookieValue, expiryDays) {
    var expiryDate = new Date();
    expiryDate.setDate(expiryDate.getDate() + expiryDays);

    var cookieValueEncoded = encodeURIComponent(cookieValue);
    var cookieString = cookieName + "=" + cookieValueEncoded + "; expires=" + expiryDate.toUTCString() + "; path=/";

    document.cookie = cookieString;
}

/**
 * This function retrieves the value of a specific cookie by its name.
 * @param cookieName - The name of the cookie that you want to retrieve the value for.
 * @returns the value of the cookie with the specified name. If the cookie is not found, an empty
 * string is returned.
 */
function getCookie(cookieName) {
    var cookieValue = "";
    var cookieArray = document.cookie.split(";");

    for (var i = 0; i < cookieArray.length; i++) {
        var cookiePair = cookieArray[i].split("=");
        var name = cookiePair[0].trim();

        if (name === cookieName) {
            cookieValue = decodeURIComponent(cookiePair[1]);
            break;
        }
    }

    return cookieValue;
}

const current_theme = getCookie('dmiesys-theme');

/**
 * The function sets the theme of the webpage to either dark or light mode and saves the preference as
 * a cookie.
 * @param theme - a string that specifies the theme to be set, either 'dark' or 'light'.
 */
function setTheme(theme) {
    if (theme == 'dark') {
        if (!document.body.classList.contains('dark')) document.body.classList.add('dark');
        document.body.style.backgroundColor = 'black';
        if (dark_mode_btn.classList.contains('bi-sun-fill')) {
            dark_mode_btn.classList.remove('bi-sun-fill');
            dark_mode_btn.classList.add('bi-moon-stars-fill');
        }
        setCookie("dmiesys-theme", "dark", 90);
    }
    else if (theme == 'light') {
        if (document.body.classList.contains('dark')) document.body.classList.remove('dark');
        document.body.style.backgroundColor = '	#F8F8F8';
        if (dark_mode_btn.classList.contains('bi-moon-stars-fill')) {
            dark_mode_btn.classList.remove('bi-moon-stars-fill');
            dark_mode_btn.classList.add('bi-sun-fill');
        }
        setCookie("dmiesys-theme", "light", 90);
    }
}


/* This code block is checking the current theme stored in a cookie and setting the theme of the
webpage accordingly. If the current theme is 'dark', it sets the theme to 'dark' using the
`setTheme()` function. If the current theme is 'light', it sets the theme to 'light'. If the current
theme is not set, it checks if the user's system preference is for dark mode using
`window.matchMedia('(prefers-color-scheme: dark)').matches`. If the user's system preference is for
dark mode, it sets the theme to 'dark'. Otherwise, it sets the theme to 'light'. */
if (current_theme == 'dark') setTheme('dark');
else if (current_theme == 'light') setTheme('light');
else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    setTheme('dark');
}
else setTheme('light');

/**
 * The function toggles between dark and light themes based on the current theme stored in a cookie.
 */
function toggleDarkMode() {
    const theme = getCookie("dmiesys-theme");
    if (theme == 'dark') setTheme('light');
    else if (theme == 'light') setTheme('dark');
}
