# Part -1 Basic Reversing Engineering 

This series will contain explaination of some easy/medium crackmes I solved from [crackmes.one,](https://crackmes.one/)

Note : This writeup will not cover anything in depth , rather this is just my way of approaching reversing challenges(mainly Linux RE challs).

If you are new to Linux Reverse engineering you can refer [**this awesome article**](https://osandamalith.com/2019/02/11/linux-reverse-engineering-ctfs-for-beginners/) as a kickstarter.

Linux RE challenges will require basic understanding of Assembly too , you can check out this [**awesome 10 min video**](https://youtu.be/75gBFiFtAb8) for grabbing basic concepts, You might find assembly a little bit difficult , but soon you will start falling in love with assembly ❤.

#### Skill set required :

1. Basic understading of Linux commands

1. Familiarity with assembly(x86)

1. Understanding of C/C++ code

1. And ofcourse brain.exe and catchy_eyes.exe

#### Tools Required :

#### [Ghidra](https://github.com/NationalSecurityAgency/ghidra)

Ghidra is a software reverse engineering (SRE) framework created and maintained by the [**National Security Agency**](https://www.nsa.gov) Research Directorate. This framework includes a suite of full-featured, high-end software analysis tools that enable users to analyze compiled code on a variety of platforms including Windows, macOS, and Linux.

#### [Radare2](https://github.com/radareorg/radare2)

**Radare2** (also known as **r2**) is a complete [**framework**](<https://en.wikipedia.org/wiki/Framework_(software)>) for [**reverse-engineering**](https://en.wikipedia.org/wiki/Reverse-engineering) and analyzing binaries; composed of a set of small utilities that can be used together or independently from the [**command line**](https://en.wikipedia.org/wiki/Command_line)

**Fun Fact** : Radare2 made appearance in **Mr.Robot **too, I mean isnt it cooool?

# **Challenge 1 : easy keyg3nme**

You can download this file from [here](https://crackmes.one/static/crackme/5da31ebc33c5d46f00e2c661.zip) (password : crackmes.one)

After extracting the downloaded zip file you will see a file named “keyg3nme”

Right now we have no idea what this file is , so lets run a **file** command on the given file

**file command** is used to determine the type of a file. **_.file_** type may be of human-readable(e.g. ‘ASCII text’) or MIME type(e.g. ‘text/plain; charset=us-ascii’). This command tests each argument in an attempt to categorize it.

[More about file command : [https://www.geeksforgeeks.org/file-command-in-linux-with-examples/]](https://www.geeksforgeeks.org/file-command-in-linux-with-examples/)

Output from file command :

![](https://cdn-images-1.medium.com/max/3686/1*eKVYyzX9PVD4f6QtMaMqnQ.png)

from **file** command it is clear that **keyg3nme** is an ELF 64-Bit executable (non stripped).

Lets run this binary.

![](https://cdn-images-1.medium.com/max/1742/1*VxWW2xVIes4OBFYY3yCbjw.png)

On running this binary , we are asked to enter a key, and obviously we don’t know the correct key, and on entering any random key we are getting a “nope” message. Our goal here is to find the correct key.

Lets run **strings** command to find out printable strings in this binary.

![](https://cdn-images-1.medium.com/max/1914/1*kMSfVijiOhLlIujAM2RUkg.png)

I found some interesting strings :

1. **Enter your key :**

1. **Good job mate, now go keygen me** [this will be displayed when user will enter the correct key]

1. **nope** [this will be displayed when user will enter the wrong key]

But unfortunately there is no **hardcoded key** present in the binary,neither any strcmp functions

**Fun Fact** : CTFs challenges arent just about `strings challfile | grep flag`

Lets Open this file in Ghidra for decompiling and analyzing function definitions.

on first time opening the binary in ghidra you will see this pop-up

![](https://cdn-images-1.medium.com/max/1142/1*nzIrW--Eg3O8PGdyM6GlMg.png)

Click on **yes** and then on **analyze**.

On this left side of the ghidra’s interface you will see symbol tree.

![](https://cdn-images-1.medium.com/max/538/1*xdnhcom-kloH1FE8WG9BRA.png)

Search for **main** function and start analyzing the **main** function.

**Note** : As this is the first challenge in this series that’s why am analyzing decompiled C code , in the further challenges I might directly analyze assembly code(using radare2).

#### Main function

![](https://cdn-images-1.medium.com/max/1002/1*IAtGAjAyU0mRUSlEYZPdrg.png)

This code seems to be this pretty straightforward, lets breakdown the variables first.

**ivar1** : It is just for returning status (if ‘1' then Pass)

**local_14** : Our entered key

**local_14** is getting passed in a function named **validate_key,** the returned result will be saved in **ivar1**, and if that result is ‘**1**’ (**ivar1** is **1**)that means our entered key is correct.

Lets take a look at **validate_key** function.

#### validate_key

![](https://cdn-images-1.medium.com/max/598/1*ypSPaH2Rje3nI15hh0e58Q.png)

this function is pretty straightforward and self explainatory,

**iParm1** is our entered key(**ivar1** in main),

**0x4cf** in decimal is equivalent to **1223**

Logic is pretty simple :

`if entered_key % 1223 == 0:`

`print("Good Job mate,now go keygen me")`

So our answer key will be **1223** , or any multiple of **1223** , or **0**

#### Correct Key

![](https://cdn-images-1.medium.com/max/1766/1*JBfIi2iIdHI6xz6bwBmfiw.png)

Wooohooo We just solved our first crackme challenge.

Try out some more challenges here : [https://crackmes.one](https://crackmes.one) .

Next Part : [https://medium.com/@Asm0d3us/part-2-crackmes-one-beginner-friendly-reversing-challenges-5e58a8a42e26](https://medium.com/@Asm0d3us/part-2-crackmes-one-beginner-friendly-reversing-challenges-5e58a8a42e26)

#### Contact

twitter : twitter.com/devanshwolf
