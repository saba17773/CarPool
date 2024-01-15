# gotify.js
Minimal alert not need css
## Usage
HTML
```html
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>gotify.js</title>
  <script src="jquery-1.12.0.min.js"></script>
  <script src="gotify.min.js"></script>
</head>
<body>

  <div class="gotify-overlay"></div>
  
  <div class="gotify">
    <div class="gotify-wrap">
        <div class="close-gotify" onclick="return close_gotify()"></div>
        <div class="gotify-content"></div>
    </div>
  </div>
  
</body>
</html>
```
Javascript
```javascript
gotify('Hello World!', 'success');
gotify('Hello World!', 'danger');
gotify('Hello World!', 'info');
gotify('Hello World!', 'warning');
```
