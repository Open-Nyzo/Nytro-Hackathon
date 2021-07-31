# Pixo.gallery source

This code is powering the pixo.gallery at release time.  
It may not reflect current state of the website in further states.

**All our code is released under MIT Licence.**  
Some third part code and libraries may rely on other open source licences, see file headers if needed.

# **Website is available at https://Pixo.gallery/ **

# Technology used

Powered by PHP  
Javascript - Vanila and JQuery  
Client/server communication by websocket  
Ratchet websocket server  
Using custom API from Nyzo.today   
Farbtastic color picker http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/  
Browserified nyzostrings https://github.com/AngainorDev/NyzoStrings/tree/master/JavaScript  
Peace and love

No pixel was harmed in the making of this project.

# Use of the NFTs:

nPIXO64 NFTS will be used. Every Pixel is a NFT with its location as part of its id.

For instance, pixel at col 20 and line 10 is nPIXO64:19_9  (first line and col is index 0)    
No need for complex schema in our case.

Once issued, the owner of that instance can set its color with a single data transaction, using "color" as comment. 

Data payload is for instance `ND:nPIXO64:19_9:color`  
The color to use is encoded in the recipient as RGB. the first 3 bytes are read as R, G and B components and the rest is ignored.

# The GUI

The grid displays the pixels in their current state.  
At start, there is a single test pixel, nPIXO64:20_10, almost red.

You can search for pixels by entering an address on top. The pixels owned by that address will be selected.  
You can also click on any pixel, and get its owner.  

Once a pixel is selected, you are able to change its color (if you are the owner).  
Select the pixel, its color, then "Get and copy tx": You'll get a prefilled string you can use in your favorite Nyzo wallet to set the color.  
The amount of the transaction is 0.000001 nyzo (You may need to enter it manually depending on the wallet)

We hope to see more easy ways of sending transactions soon.








