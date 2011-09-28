# GitHub OAuth

* Version: 0.1.0
* Author: Remie Bolte <http://github.com/remie>
* Build Date: 2011-09-28
* Requirements: Symphony 2.2.3, PECL http module <http://nl.php.net/manual/en/function.http-post-data.php>

## Installation

1. Download the GitHub OAuth extension and upload the `githuboauth` folder to the `extensions` folder.
2. Enable the extension by selecting `GitHub OAuth` in the list and choose `Enable` from the with-selected menu, then click Apply.
3. Edit the application credentials and scope in the `Preferences` screen

## Usage

After installing this extension and providing the required information you can use it by adding the `GitHub Authentication` event to one of your pages.

The event is triggered automatically and will redirect the user to the GitHub login page. Upon granting permission the user is redirected back to the application and the authentication token is retrieved.

A `github` event is added to the event XML in your page output. If the authentication is successful, the `token` is added as attribute.

It is advised to only use this token server-side. Based on the application scope it might provide read/write access to User information and repositories on GitHub. You can either retrieve it from the event list or access the 'token` value from the `github` session cookie in your custom events.

## Roadmap

The plan is to further develop this extension with several events to allow specific user information to be added to the output XML for usage in XSLT templates.

## Version History

### 0.1.0

* initial release of this extension