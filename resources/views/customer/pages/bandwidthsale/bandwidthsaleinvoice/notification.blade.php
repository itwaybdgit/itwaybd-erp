<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        body {
  align-items: center;
  display: flex;
  font-family: Neucha;
  height: 100vh;
  justify-content: center;
  margin: 0;
  padding: 0;
  width: 100vw;
}

.country-info {
  align-items: center;
  display: flex;
  flex-direction: column;
}

.drawing {
  align-items: center;
  display: flex;
  height: 72px;
  justify-content: center;
  width: 96px;
}

.drawing--end {
  align-items: flex-end;;
}

.box {
  background-color: #F8961E;
  border-radius: 0 15% 0 0;;
  height: 36px;
  margin: 16px 0 0 19px;
  position: relative;
  width: 64px;
  transform: skew(-4deg);
  &:after {
    background-color: #F3722C;
    border-radius: 15% 15% 0 0;
    box-shadow: 0;
    content: '';
    display: block;
    height: 36px;
    margin-left: -19px;
    position: relative;
    width: 22px;
  }
}

.flag {
  background-color: #F94144;
  height: 35px;
  left: 0;
  margin: auto;
  position: absolute;
  right: 0;
  top: -16px;
  width: 4px;
  transform: skew(-7deg);
  &:after {
    background-color: #F94144;
    border-radius: 15%;
    content: '';
    height: 10px;
    position: absolute;
    width: 16px;
  }
}
    </style>
</head>
<body>
    <section class="country-info">
        <div class="drawing drawing--end">
          <div class="mailbox">
            <div class="box">
              <div class="flag"></div>
            </div>
          </div>
        </div>
        <h1 style="text-align: center">{{$mess}}</h1>
      </section>
</body>
</html>
