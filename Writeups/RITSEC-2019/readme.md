# RITSEC WEB CTF CHALLENGES 

![](https://cdn-images-1.medium.com/max/1386/1*BVbSQVSOxEbDAAYfR1JLmQ.png)

**Ritsec CTF** was fun, however I roughly spent around 1 hour solving only web challenges (was sick _coughhhs_) , though I was able to solve 5 out of 6 web challenges.

# Challenge 1 : Misdirection

![](https://cdn-images-1.medium.com/max/1494/1*V8n61RrKiEVmZMTem20uWA.png)

We are provided with a url : http://ctfchallenges.ritsec.club:5000/ . Challenge description goes like : “**Looks like someone gave you the wrong directions!**”

On visiting that url ,We are getting this error :

![](https://cdn-images-1.medium.com/max/2744/1*bEMfUZA5AgVXbbC6BDw6Eg.png)

Seems like the page is getting stuck in some kind of **infinite redirection loop**,eventually the page breaks ,and we are greeted with an error “**The page isn’t redirecting properly**”

I used **network** tab of **inspect element** for analyzing the requests.

![](https://cdn-images-1.medium.com/max/3840/1*reV1qdzekVo4GftNmPjDEw.png)

If you look closely ,you will find out that the **file** section is containing the chars of the flag, on putting them together we got our flag

Flag : **RS{Ke3P-mov1ng-4!way}**

# Challenge 2 : Buckets of fun

![](https://cdn-images-1.medium.com/max/1486/1*Zq9J_5XVvsZE5I3guHPCkg.png)

Name of the challenge itself indicates that the challenge is about **s3 bucket**,On visiting the URL we are asked for **password.**

![](https://cdn-images-1.medium.com/max/1954/1*3V0j2WnUEhDz0yFKMQW_OQ.png)

It is obviously clear that this challenge has nothing to do with finding out the **password**, rather the page we are looking at is just index.html,Our goal is to find out the keys/files uploaded on this bucket.

First thing I do while solving challenges related to s3 buckets is : changing the url to standard form i.e **{bucket-name-here}.s3.amazonaws.com**

```
[http://bucketsoffun-ctf.s3-website-us-east-1.amazonaws.com/](http://bucketsoffun-ctf.s3-website-us-east-1.amazonaws.com/)

will become

[http://bucketsoffun-ctf.s3.amazonaws.com/](http://bucketsoffun-ctf.s3-website-us-east-1.amazonaws.com/)
```

![](https://cdn-images-1.medium.com/max/1668/1*nic0Rq2lNSgXzLnpl957Gg.png)

We found a text file **youfoundme-asd897kjm.txt,** and eventually got our flag in that text file.

![](https://cdn-images-1.medium.com/max/2150/1*vzmEaRqsGvSF-yTea3FvZA.png)

# **Challenge 3 : Potat0**

![](https://cdn-images-1.medium.com/max/1484/1*U2Lv5UyVhpjirmQLM8Rvjw.png)

On visiting the given URL, we found no useful information,just kind of a blank page

![](https://cdn-images-1.medium.com/max/3832/1*HzhOLaJ3Fd0ExDtjAiZdmw.png)

Source-code :

![](https://cdn-images-1.medium.com/max/1028/1*BXVXojYc7X1S8jEKj4SdKA.png)

This comment grabbed by attention, I went ahead and ran **gobuster.**

![](https://cdn-images-1.medium.com/max/1618/1*12Z5xX4ELJYu1otkMAdsyg.png)

Found some interesting files/dirs .From **upload.php** it is kind of clear that the challenge is about getting a **shell** and eventually finding out **flag.txt** (just speculations as of now)

![upload.php](https://cdn-images-1.medium.com/max/1706/1*aF_nYXutLW10rVMxIY6kjg.png)

I embedded a simple **php webshell** in **png file** using **exiftool** and uploaded that.

```
Refer this for shell uploading techniques : [https://github.com/xapax/security/blob/master/bypass_image_upload.md](https://github.com/xapax/security/blob/master/bypass_image_upload.md)
```

and eventually got flag here : [\*\*http://ctfchallenges.ritsec.club:8003/upload?cmd=cd](http://ctfchallenges.**ritsec.club:8003/upload?cmd=cd) /;cd home;cat flag.txt

# **Challenge 4 : Our First API**

![](https://cdn-images-1.medium.com/max/1476/1*K-ZzTxf5ZJDTi3GxQUhESg.png)

we are provided with two urls :

```
[http://ctfchallenges.ritsec.club:3000/](http://ctfchallenges.ritsec.club:3000/)
[http://ctfchallenges.ritsec.club:4000/](http://ctfchallenges.ritsec.club:4000/)
```

![[http://ctfchallenges.ritsec.club:3000/](http://ctfchallenges.ritsec.club:3000/)](https://cdn-images-1.medium.com/max/2264/1*4ABo6qtnFHNjnh6IpnK8Gg.png)

![[http://ctfchallenges.ritsec.club:4000/](http://ctfchallenges.ritsec.club:4000/)](https://cdn-images-1.medium.com/max/3782/1*TngaNg35DswCQ70hOL7EWQ.png)

This page gives us 3 different api endpoints to play with around

```
/api/admin      : for admins
/api/normal     : for normal users
/auth           : for authentication
```

![last line](https://cdn-images-1.medium.com/max/3148/1*vK7RGomqEs2bTa-6dLVufQ.png)

This catched my attention and hence I sent a name parameter using GET request.

`[http://ctfchallenges.ritsec.club:3000/auth?name=devanshbatham](http://ctfchallenges.ritsec.club:3000/auth?name=devanshbatham)`

![](https://cdn-images-1.medium.com/max/3840/1*S1mahy0sXc2V4QJaRs5IPw.png)

We got a token and if you are into web security field ,you can instantly figure out that it is indeed a JWT token.

I debugged that JWT using jwt.io and got this.

![](https://cdn-images-1.medium.com/max/2732/1*PCxEBMs4j_OktNnTZ4s_QQ.png)

Lets pass this JWT authoraization header , while accessing endpoint /api/normal

![](https://cdn-images-1.medium.com/max/3514/1*LVpal6tjt7fkYFgte5wFQA.png)

**{“flag”:”Congrats on authenticating! Too bad flags aren’t for normal users !!”}**

Lets try accessing /api/admin with the same JWT.

![no flag](https://cdn-images-1.medium.com/max/3280/1*eO2lESRJ8XjNNeC8Z3CIBA.png)

**{“reason”:”Not an admin!”}**

After debugging that **JWT** we can see that the **type** is set to **user** , our target is to create a new **JWT** token with **type** set to **admin**

I used this awesome tool : [https://github.com/ticarpi/jwt_tool/blob/master/jwt_tool.py](https://github.com/ticarpi/jwt_tool/blob/master/jwt_tool.py) and tampered the JWT (changed **type** from **user** to **admin**)

sent the modified **JWT** in request body under **authorization** header and got the flag

`{“flag”:”RITSEC{JWT_th1s_0ne_d0wn}”}`

# **Challenge 5 : Hop By Hop**

![](https://cdn-images-1.medium.com/max/1478/1*dhAF6jj9YqZ7ogTW1PHJ4g.png)

We are given this url : [http://ctfchallenges.ritsec.club:81](http://ctfchallenges.ritsec.club:81)

`I solved this challenge after the CTF hours`

The name of the challenge explains it all **Hop By Hop,** it is related to Hop By Hop headers

For the purpose of defining the behavior of caches and non-caching proxies, we divide HTTP headers into two categories:

- **End-to-end headers**, which must be transmitted to the ultimate recipient of a request or response. End-to-end headers in responses must be stored as part of a cache entry and transmitted in any response formed from a cache entry.

- **Hop-by-hop headers**, which are meaningful only for a single transport-level connection, and are not stored by caches or forwarded by proxies.

The following HTTP/1.1 headers are hop-by-hop headers:

- **Connection**

- **Keep-Alive**

- **Public**

- **Proxy-Authenticate**

- **Transfer-Encoding**

- **Upgrade**

All other headers defined by HTTP/1.1 are end-to-end headers.

**Ref**: [https://www.freesoft.org/CIE/RFC/2068/143.htm](https://www.freesoft.org/CIE/RFC/2068/143.htm)

We can bypass our IP check using **X-Forwarded-For** header,

so our final header will look like :

`connection : Close,X-forwarded-For`

add this header in request body while accessing **/admin**

![](https://cdn-images-1.medium.com/max/3582/1*qZr0m_VFHC4sfoRjGqg8bg.png)

and we got our Flag.

`flag : RITSEC{2227DF03559A4C4E1173BF3565964FD3}`

Thats all for now

#### Contact

twitter : https://twitter.com/devanshwolf
