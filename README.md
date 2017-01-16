# LegacyMVC (Defunct)

https://sourceforge.net/projects/texocms/

## History/Reasoning

Sometime around 2004/2005 I started to actively engage community members at http://devnetwork.net - the majority of discussions 
which I contributed were mostly architecture and design related. There was a community movement to build a web-centric MVC 
framework based on the knowledge and experience of some of the key community members.

For whatever reason, I did not participate in that exercise directly, but I remained a keen observer and began to implement my own.

During thousands of discussions with members of http://devnetwork.net I learned a great deal about what makes "good" software, at least in 
the minds of the many. Topics such as *Open-Closed Principle* (the "O" in S.O.L.I.D), design patterns Strategy, Facade, Factory, etc were discussed frequently 
and passionately by all. This motivated me to "learn by example" and implement a light-weight (minimal or no dependencies) micro-mvc framework. 
What started as a God-like page controller leaned out over time into what it consists of today, plus or minus a few components.

LegacyMVC is what remains of the decade long journey. At one point, this project was three times the current size, as I had implemented a 
semi-functioning ORM, sophisticated views management layer (à la: Drupal render arrays), as well as a forms and validation component.

As tools like Packagist became defacto and other publicly available frameworks like Symfony and Zend gained momentum, my interest in 
this framework started to wane and eventually I stopped developing it completely (circa: 2010). It was never open-sourced and only ever used 
for my own projects, and the company I work for. I am sharing this framework not for the code but maybe a shared experience? That being said, I have no interest 
in pursuing future developments of this framework, as I strongly believe Symfony is the toolkit all PHP developers should be using.

## Objectives

Light-weight controller-centric framework along with various utility libraries. Follow S.O.L.I.D principles and implement all patterns accordingly; No reason to 
call a component "Builder" when it is actually a "Factory". Strong focus on loose coupling and high cohesion, and heavy use of inversion of control
to allow programmer flexibility. This was to be enforced by what I called a Consumer Provider Best Practice - not to be confused with 
Producer Consumer Pattern. You see this pattern all the time with components like databases, caching, session management, etc. 

Basically when working with a consumer and provider instance, the two functions are distinctly separated and abstracted away accordingly. The provider 
would implement a bulk of the "work" and the container (ie: consumer) only provided an interface to the client developer. While technically, this is 
dependency injection, I referred to it by a new name to re-enforce the idea that consumers were essentially dynamic delegates or proxies to the underlying
provider class.

## Components

Implementing the controller coordination for MVC, as it turns out, is quite a simple task. Conceptually a controller only need be invoked and basically 
hand off control to a model and/or view and return the result back to the user agent.

1. Front Controller
 1.1. Controller Router
 1.2. Controller Dispatcher
2. Action Controller
3. Filter Controller

