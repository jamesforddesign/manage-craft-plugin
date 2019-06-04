# ManageCraft plugin for Craft CMS 3.x

Provides access to available CMS and plugin updates.

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require jamesforddesign/manage-craft

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for ManageCraft.

## Configuring ManageCraft

This plugin makes information relating to Craft and installed plugins available at yoursite.com/actions/manage-craft.

You probably don't want this information to be publicly accessible. To secure this endpoint, enter an Access Key in the plugin's settings.