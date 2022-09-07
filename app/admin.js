import HandleSettingsPage from './handleSettingsPage';

// Handles store details.
const enableStoreDetails = new HandleSettingsPage();
window.onload = function(e)
{
    enableStoreDetails.init();
};