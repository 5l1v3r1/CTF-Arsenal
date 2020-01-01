# Part -2 Basic Linux Reverse Engineering

In [**last writeup**](https://medium.com/@Asm0d3us/1-crackmes-one-beginner-friendly-reversing-challenges-6df94ea6b29d) ,We solved a simple crackme challenge using **Ghidra**, that was fun . wasn’t that?

Now before solving other crackmes , lets code and compile our own crackme and eventually crack it,the whole purpose of solving our own crackme is to demonstrate the usage of **ltrace**(another powerful utility while solving Linux RE challs).

Below is a [simple C code](https://github.com/NoraCodes/crackmes/blob/master/crackme01.c) :

#### ourcrackme.c

```
#include <stdio.h>
#include <string.h>

int main(int argc, char** argv) {

if (argc != 2) {
        printf("Need exactly one argument.\n");
        return -1;
    }

char* correct = "Asm0d3us";

if (strncmp(argv[1], correct, strlen(correct))) {
        printf("No, %s is not correct.\n", argv[1]);
        return 1;
    } else {
        printf("Yes, %s is correct!\n", argv[1]);
        return 0;
    }

}
```

Now lets compile this C program using gcc

`gcc ourcrackme.c -o ourcrackme`

Lets run the obtained binary.

![](https://cdn-images-1.medium.com/max/1194/1*oo0fCjASNTiePQ9ITqgPhw.png)

So our goal is to obtain the correct password(ofcourse we know the correct password ,as we have C source code so for now lets just pretend that we don’t know the actual password)

There is a direct solution possible for this crackme , as the actual password is **hardcoded** in the source code, hence the actual password can be obtained just by running a **strings** command on our binary

`strings ourcrackme`

However we are not going for this direct solution and we will use **ltrace** for obtaining the actual password.

#### ltrace

**ltrace** is a program that simply runs the specified **_command_** until it
exits. It intercepts and records the dynamic library calls which are
called by the executed process and the signals which are received by
that process. It can also intercept and print the system calls
executed by the program
**ltrace** shows parameters of invoked functions and system calls. To
determine what arguments each function has, it needs external
declaration of function prototypes.

More about **ltrace** and its usage : [Can be found here](http://man7.org/linux/man-pages/man1/ltrace.1.html)

#### Solving using ltrace

![](https://cdn-images-1.medium.com/max/2406/1*tRiF2OYpJqSW5C4LT87c8w.png)

As you can see that we supplied `passwordhere` as argument , and ltrace intercepted the dynamic library calls, We can see that our supplied input(i.e passwordhere )is getting compared with hardcoded password (i.e `Asm0d3us` ) using `strncmp` function , the supplied input is only compared till 8 chars , that means that the first 8 chars of our supplied input must be equal to Asm0d3us rest can be anything,

so the possible correct passwords can be :

```
Asm0d3us
Asm0d3us12
Asm0d3us1234
Asm0d3us12345
......
......
and so on
```

![](https://cdn-images-1.medium.com/max/1214/1*_LYWz7QqxPvsHm60fR910A.png)

I hope the basic usage of **ltrace** is clear now , ltrace can be really handy while analyzing dynamic library calls in Linux RE challenges.

Now lets solve our next **crackme**.

# **Rev**

Binary can be downloaded from [here](https://drive.google.com/open?id=1pemgsyMyiJcyc1NuO8xebtPkgPysPfL6)

lets do some information gathering over this binary.

#### file

```
levi@leviackerman:~/Desktop/CTFs/Base/reversing/Crackme-one$ file rev
rev: ELF 64-bit LSB shared object, x86-64, version 1 (SYSV), dynamically linked, interpreter /lib64/l, for GNU/Linux 3.2.0, BuildID[sha1]=6db637ef1b479f1b821f45dfe2960e37880df4fe, not stripped
```

#### running the binary

![](https://cdn-images-1.medium.com/max/1974/1*VB8VYYPJP5I0v1oUUkn41w.png)

We need to supply the correct password as argument and ofcourse that’s what we need to find by reversing this binary.

#### strings

```
levi@leviackerman:~/Desktop/CTFs/Base/reversing/Crackme-one$ strings rev

/lib64/ld-linux-x86-64.so.2
libc.so.6
exit
puts
printf
strlen
__cxa_finalize
__libc_start_main
GLIBC_2.2.5
_ITM_deregisterTMCloneTable
__gmon_start__
_ITM_registerTMCloneTable
<[@u](http://twitter.com/u)-H
AWAVI
AUATL
[]A\A]A^A_
USAGE: %s <password>
try again!
Nice Job!!
flag{%s}
....
....
```

Flag isn’t hardcoded in the source , flag is dynamically generated based on our input, from the `strings` command it is clear that flag is something like `flag{%s}` , we still need to find that `%s`string. No doubt that `%s`is nothing but our supplied input , there must be some checks/conditions for an input to be a correct password and what we need to find out, so lets dig into this.

#### Ghidra comes to rescue

Its just a matter of choice what decompiler we chose while dealing with binaries ,But my Personal preference is Ghidra ,maybe because of its simple and easy to use interface.

```
> create a new project in ghidra
> select the binary
> click on analyze
```

Lets just move to main function

#### main

![](https://cdn-images-1.medium.com/max/890/1*hZ1d9YxDatmBkbnpnGtvbQ.png)

Now its not necessary to change the main function’s signature , but I always do it because I like to deal with standard variables like `argv/av and argc/ac`.it somewhat increases the readability of the code too.[You can skip this part]

```
> right click ,and chose 'edit Function Signature
> set function signature to : int main(int ac, char** av)
```

#### **main**

![a more readable code](https://cdn-images-1.medium.com/max/754/1*Ss1zduomYVl2dgpusYNh1g.png)

lets break down the variables :

```
ac : no of arguments
av : it is an array,where our supplied input is at index av[1].
sVar1 : contains the length of our supplied input.
```

Code is pretty straightforward and self explainatory.

there are two checks that are taking place.

```
> the length of entered strings must be 10 chars
> av[1][4] (i.e 5th char of our supplied input must be equal to '@' symbol.

```

So the possible answers to this crackme can be :

```
aaaa@aaaaa  [10 char length and 5th char is '@']
bbbb@bbbbb  [10 char length and 5th char is '@']
cccc@cccc   [10 char length and 5th char is '@']
```

![](https://cdn-images-1.medium.com/max/1902/1*NOzrriufEeIV_hH5t-fg-w.png)

Woohoo we are really getting along in Linux RE.

#### contact

twitter : twitter.com/devanshwolf
