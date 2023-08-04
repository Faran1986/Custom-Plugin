=============== Jefferson County =============
version : 1.0.0


================ Description =================
The Jefferson County Plugin is a WordPress Plugin designed to integrate with Google Calendar. Users have the ability to import events from their Google Calendar via an .ICS file. Once imported, these events are transformed into posts under the custom post type 'calendar_events'. In addition, this plugin facilitates category management for these events.

A major feature of the Jefferson County Plugin is its dynamic calendar view. Users can observe their events in four different layouts: Monthly, Weekly, Daily, and Agenda. To enhance user experience, the plugin provides a search function and category filter, allowing users to easily locate specific events.


================ Installation ================

In WordPress:

1. Go to Plugins > Add New
2. Press Upload Plugin
3. Attach Plugin Zip File
4. Press "Install Now"
5. Press "Activate Plugin"

Manual installation:

1. Upload the `jefferson-county` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the "Plugins" menu in WordPress


================ Usage ================

Upon installation, the plugin adds two new menu items to your WordPress dashboard: 'Import Events' and 'Calendar Events'.

In the 'Import Events' menu, you'll find a form and a table. Here, you can upload an .ICS file from your Google Calendar by choosing the file and clicking 'Import'. This will import your events and create individual posts under the 'Calendar Events' post type. After importing, the new entries will be displayed in the table beneath the form. You also have the option to download the imported .ICS file by clicking the link in the 'Import URL' column.

In the 'Calendar Events' menu, all imported events are stored as posts, which can be viewed and edited as needed.

For the front-end display of your events, use the shortcode [calendar_template] where you want the calendar to appear. This will provide your site visitors with four different view options (Monthly, Weekly, Daily, Agenda) for your events calendar. Additionally, this front-end display allows users to search for specific events or filter by category for more streamlined navigation.