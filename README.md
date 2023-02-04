
# X-UI (V2ray) API

A simple api from X-UI for use in your telegram robot or applications


## Example

Example for begin

```php
  <?php
  reqiure './x-ui.php';
  # Begin Class
  $LoL = XUILoL('Getaway','Username','Password'); # Getaway With Port Ex : 192.168.11.:54321
  print_r($LoL->GetServerStatus()); # Print Server Status
  ?>
```


## Functions Reference

#### Server Status

```php
  GetServerStatus()
```

| Parameter | Return     | Description                |
| :-------- | :------- | :------------------------- |
| `--------` | `array` | Give a few information of your server status|

#### Users

```php
  GetUsersList()
  DeleteUser()
  ResetUsage()
  ChangeStatus()
```

| Function | Parameter | Return     | Description                       |
| :-------- | :-------- | :------- | :-------------------------------- |
| `GetUsersList`      | `---------`      | `array` | Array of full information about users |
| `DeleteUser`      | `ID`      | `bool` | **Required** : ID of user - Delete User |
| `ResetUsage`      | `ID`      | `bool` | **Required** : ID of user - Reset Usage |
| `ChangeStatus`      | `ID`      | `bool` | **Required** : ID of user - Turn On or Off user account |

#### New account

```php
  AddUserVmess()
  AddUserVless()
```

| Parameter | Return     | Description                |
| :-------- | :------- | :------------------------- |
| `Username , ExpireDate , UsageMax , Port` | `bool` |**Required** : `Username` , `ExpireDate`  - Create Vless Or Vmess Protocol With WebSocket Transsmation|



## Author

- [@iDevLoL](https://www.github.com/iDevLoL)

