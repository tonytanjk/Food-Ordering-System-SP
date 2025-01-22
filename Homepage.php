<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Homepage</title>
        <style>
        body {
            font-family: "Meta", sans-serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, .2), rgba(0, 0, 0, .2)), url("foodab.jpg");
            background-size:cover;
        }
        
        :root {
            --gold: #ffb338;
            --light-shadow: #77571d;
            --dark-shadow: #3e2904;
            --color-background: #000119;
            --stroke-width: calc(1em / 5);
            --font-size: 55px;
            --font-weight: 900;
            --letter-spacing: calc(1em / 10);
        }
        
        .wrapper {
          background: transparent;
          backdrop-filter: blur(7px);
          display: grid;
          grid-template-areas: 'overlap';
          place-content: center;
          text-transform: uppercase;
          transition:0.5s;
          padding-left:20px;
          padding-right:20px;
          border-radius: 20px;
          box-shadow:2px 2px 3px 1px #000;
          height: 150px;
        }
        
        .wrapper > div {
          background-clip: text;  
          -webkit-background-clip: text;
          color: #363833;
          font-family: 'Poppins', sans-serif;
          font-weight: 900;
          font-size: 70px;
          grid-area: overlap;
          letter-spacing: 1px;
          -webkit-text-stroke: 4px transparent;
        }
        div.bg {
          background-image: repeating-linear-gradient( 105deg, 
            var(--gold) 0% , 
            var(--dark-shadow) 5%,
            var(--gold) 12%);
          color: transparent;
          filter: drop-shadow(5px 15px 15px black);
          transform: scaleY(1.05);
          transform-origin: top;
        }
        div.fg{
          background-image: repeating-linear-gradient( 5deg,  
            var(--gold) 0% , 
            var(--light-shadow) 23%, 
            var(--gold) 31%);
          color: #1e2127;
          transform: scale(1);
        }
        .contents{
            color: white;
            font-weight:bold;
            margin:0;
            padding:0px;
            text-decoration: none;
        }
        p, a{
            text-decoration:none;
            letter-spacing: 4px;
            line-height: 75px;
            color:#3e3bff;
            text-transform: uppercase;
        }
        .mid{
            transition: all 0.5s;
            -webkit-text-stroke: 4px #d6f4f4;
            font-variation-settings: "wght" 900, "ital" 1;
            font-size: 40px;
            text-align: center;
            color: white;
            font-family: "Meta", sans-serif;
            text-shadow: 10px 10px 0px #07bccc,
              15px 15px 0px #e601c0,
              20px 20px 0px #e9019a,
              25px 25px 0px #f40468,
              45px 45px 10px #482896;
            cursor: pointer;
        }
        
        .mid:hover{
            font-variation-settings: "wght" 100, "ital" 0;
            text-shadow: none;
            font-size:60px;
        }
        </style>
    </head>
    <body>
        <header>
        </header>
        <div class="contents">
            <div class="wrapper">
                <div class="bg">Welcome to FoodCourt@SP</div>
                <div class="fg">Welcome to FoodCourt@SP</div>
            </div>
            <p class="mid">
                Explore various stores <br>and Food courts in SP!<br>
                Click <a  href="FC.php" id="order">Here</a> to order now!
            </p>
        </div>
    </body>
</html>