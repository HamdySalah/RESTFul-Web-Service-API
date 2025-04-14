# RESTFul-Web-Service-API
# 💻 Web Services Labs – PHP API Projects

This repository contains the solutions to two PHP-based Web Services labs. Each lab demonstrates real-world usage of APIs using modern web service technologies like REST (cURL, Guzzle) and SOAP (SoapClient).

---

## ✅ Lab 1 – Egyptian Cities Weather App (cURL & Guzzle)

A PHP script that loads a list of Egyptian cities from a local JSON file and allows the user to get the **current weather report** (temperature min, max, and humidity) using the **OpenWeatherMap API**.

### 🌦️ Features

- Dropdown list of all Egyptian cities (fetched from a local JSON file)
- Weather data is retrieved using:
  - ✅ **cURL**
  - ✅ **Guzzle (via Composer)**
- Object-Oriented Programming (OOP) structure
- Displays weather report (temperature min, max, humidity) after selection

### 🔗 API Used
- [OpenWeatherMap](https://openweathermap.org/api)

### 🛠️ Technologies
- PHP 7+
- Composer (for Guzzle)
- JSON parsing and file reading
- OOP

### 📷 Screenshots
- Before submission: city dropdown
- After submission: weather report shown above dropdown

---

## ✅ Lab 2 – Glasses Shop API (REST & SOAP)

This lab is split into **2 assignments**:

### 🧾 Assignment A – RESTful API for Glasses Shop

A complete RESTful API in PHP that manages items (CRUD operations) for a fictional glasses shop.

#### 🔄 Supported HTTP Methods

| Method | Endpoint                        | Description                    |
|--------|---------------------------------|--------------------------------|
| GET    | `/GlassShopAPI.php/items/{id}`  | Retrieve item details by ID    |
| POST   | `/GlassShopAPI.php/items`       | Add new item                   |
| PUT    | `/GlassShopAPI.php/items/{id}`  | Edit existing item             |
| DELETE | `/GlassShopAPI.php/items/{id}`  | Delete an item by ID           |

#### ❌ Error Handling

- `405 Method Not Allowed`
- `500 Internal Server Error`
- `404 Resource Not Found`
- `400 Bad Request`

#### 🛠️ Tools Used

- PHP native server
- `MySQLHandler.php` for database abstraction
- JSON input/output

#### 🎁 Bonus
- Documentation support via [apidoc.js](http://apidocjs.com/) *(optional)*

---

### 📡 Assignment B – SOAP API Client

A simple PHP client using `SoapClient` to connect to the **RadioReference API** and fetch:

- All supported countries and their codes.

#### 🔗 SOAP WSDL
```http
http://api.radioreference.com/soap2/?wsdl&v=latest
