# What is Testudo

Encryption Libraries for Password Transfer in Web-Based Systems on an Unsafe Network/Protocol (like HTTP)

# Architecture

![alt text](img/architecture.png)

# Manual

- Hash password
- Pass hashed value and password value to Testudo class instance.
- Send encrypted value to server
- Pass recieved value and hashed password stored on server-side to Testudo class instance
- Use restroed value to Authenticate

## Javascript

```js
let encrypted = testudo().form(password, hashed_password)

let decrypted = testudo().unform(sec, testudo().getSeed(hashed_password, password))
```

## Csharp

```csharp
string encrypted = testudo.form(password, hashed_password);

string decrypted = testudo.unform(secret, testudo.getSeed(hashed_password, password));
```

## Php

```php
$encrypted = $testudo->form($password, $hashed_password);

$decrypted = $testudo->unform($sec, $testudo->getSeed($hashed_password, $password));
```
