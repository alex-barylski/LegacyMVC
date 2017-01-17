## History/Reasoning

Sometime around 2004/2005 I started to engage with the community over at http://devnetwork.net - the majority of discussions 
which I participated were mostly software design related. For a time, there was a community movement to build a web-centric MVC 
framework based on the knowledge and experience of some of the community members. I remained a keen observer but nothing more.

During those discussions I learned a great deal about what makes "good" software, at least in the minds of the many. Topics such as 
*Open-Closed Principle* (the "O" in S.O.L.I.D) and design patterns like Strategy, Facade and Factory were discussed frequently. 
This motivated me to "learn by example" and implement a light-weight (minimal or no dependencies) MVC framework. 

What started as a God-like page controller leaned out over time into what it 
consists of today, plus or minus a few components.

I am sharing this framework not for the code, or at least it's functional use, but 
maybe a shared experience or posterity? That being said, I strongly believe Symfony 
is the toolkit all PHP developers should be using - it has become my silver bullet.

## Objectives

Be a light-weight, controller-centric framework, while offering various utility libraries. 
Follow [S.O.L.I.D](https://en.wikipedia.org/wiki/SOLID_(object-oriented_design)) 
principles and implement all patterns accordingly; No reason to call a component 
"Builder" when it is actually a "Factory". Strong focus on loose coupling and high 
cohesion, and extensive use of inversion of control to allow programmer flexibility. 

This was to be implied by what I called a Consumer Provider Best 
Practice - not to be confused with Producer Consumer Pattern. As developers we see 
this practice all the time with components like databases, caching, session management, etc. 

Essentially when working with a consumer and provider instance, the two functions are 
distinctly separated and abstracted accordingly. The provider would implement a bulk 
of the "work" and the consumer (ie: container) only provided an interface to the 
client developer. 

While technically this is dependency injection, I referred to it by a new name to 
re-enforce the idea that consumers were essentially delegates or proxies to the underlying
provider class.

## Architecture

Any controller architecture can range from a trivial single method implementation 
to full scale, enterprise ready, controller orchestration. I believe LegacyMVC is 
somewhere in between as I tried to achieve some flexibility, balanced with ease of use.

I needed intercepting filters as a way of globally sniffing and snuffing web requests 
and responses. I also knew I needed to perform both HTTP redirect and controller action 
forwarding, with the latter being forced through a filtering cycle as well. 

Lastly, I needed the ability to swap out the "router" component to accommodate any 
URI schema imaginable. 

I was also certain I would not want the dispatcher calling anything but object methods. 
So closures, global functions and static methods were of no interest to me. It saved 
me from having to extract the dispatcher into it's own component. 

In retrospect I would refactor the dispatcher into it's own component, I believe 
it would have resulted in a cleaner implementation when it came to handling 
RESTful requests, CLI invocation, etc.

## Components

- Front Controller
  - Controller Router
  - Controller Dispatcher (Hardcoded)
- Action Controller
- Filter Controller (Pre and Post)

