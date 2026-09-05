


## TRIBHUVAN UNIVERSITY FACULTY OF HUMANITIES AND
## SOCIAL SCIENCE

## A Project Report
## On
“MedVault: A Modern Approach to Pharmacy Management”

Submitted to
Department of Computer Application
National College of Computer Studies

In partial fulfillment of the requirements for Bachelor Degree in
## Computer Application

Submitted by:
## Name: Rijan Bajracharya
## Roll: 6-2-551-39-2021

## 07/12/2024

Under the Supervision of
## Mr. Teksan Gharti Magar

ii


## Tribhuvan University
Faculty of Humanities and Social Sciences
National College of Computer Studies

## Supervisor’s Recommendation

It  is  my  pleasure  to  recommend that a report on “MedVault:  A Modern Approach to
Pharmacy Management System” has  been  prepared  under  my  supervision  by  Rijan
Bajracharya  in  partial  fulfillment  of  the  requirements  for  the  degree  of  Bachelor  of
Computer  Application  (BCA).  Their  report  is  satisfactory  to  process  for  the  final
evaluation.

## .....................................
## SIGNATURE
## Teksan Gharti Magar
## SUPERVISOR
## Faculty Member
Department of Computer Application
National College of Computer Studies


iii



## Tribhuvan University
Faculty of Humanities and Social Sciences
National College of Computer Studies

## LETTER OF APPROVAL

This is to certify that this project prepared by Rijan Bajracharya entitled “MedVault: A
Modern Approach to Pharmacy Management System” in  partial  fulfillment  of  the
requirements for the degree of Bachelor in Computer Application has been evaluated. In
our opinion it is satisfactory in the scope and quality as a project for the required degree.

SIGNATURE of Supervisor



## Teksan Gharti Magar
## Faculty Member
Department of Computer Application
National   College   of   Computer   Studies
## Paknajol, Kathmandu

SIGNATURE of HOD/ Coordinator



## Rajan Poudel
## Faculty Member
Department of Computer Application
National   College   of   Computer   Studies
## Paknajol, Kathmandu

SIGNATURE of Internal Examiner



SIGNATURE of External Examiner



iv

## ABSTRACT
“MedVault” is a web base application used to automate pharmacy workflow. This project
was  built  on  Waterfall  Methodology with  the  help  of HTML,  CSS,  JS and  PHP. This
includes feature like keeping record of medication in the store, update medication records,
purchase medicine. It enables tracking of medication stock levels, price, and quantity. This
system helps to reduce wastage, ensuring the availability of medications when needed. The
primary objective of this application is to enhance efficiency, accuracy, and safety in the
management of pharmaceutical processes. It can be used by any pharmacist to keep track
of  medicine  quantity  and  how  much  it  is  sold  or  purchased.  The  user  can  update  the
medicine record if they want to change or add new medicine.
Keywords: record keeping, inventory, Waterfall methodology

v

## ACKNOWLEDGMENT
I would like to thank my supervisor Mr. Teksan Gharti Magar for his valuable guidance
who   gave   me   great   encouragement   for   this   work   and   helpful   suggestions.   His
encouragement and practical advice were instrumental in helping us complete this project
successfully.
I  would  also  like  to  thank  our  Vice Principal sir, Mr. Santosh  Maskey who  monitored,
guided and motivated us throughout all the phases of this project. I appreciate the support
from all the supervisors, friends and family to help make this project successfully.
## Rijan Bajracharya

vi

## TABLE OF CONTENTS
ABSTRACT ....................................................................................................................... iv
ACKNOWLEDGMENT ................................................................................................... v
LIST OF ABBREVIATIONS ....................................................................................... viii
LIST OF FIGURES .......................................................................................................... ix
LIST OF TABLES ............................................................................................................. x
Introduction .............................................................................................. 11
1.1 Introduction ........................................................................................................ 11
1.2 Problem statement .............................................................................................. 11
1.3 Objectives .......................................................................................................... 11
1.4 Scope And Limitation ........................................................................................ 11
1.4.1 Limitation ....................................................................................................... 11
1.4.2 Scope .............................................................................................................. 12
1.5 Development Methodology ............................................................................... 12
1.6 Report Organization ........................................................................................... 12
Background Study and Literature Review ............................................ 14
2.1 Background Study .............................................................................................. 14
2.2 Literature Review............................................................................................... 15
System Analysis and Design .................................................................... 16
3.1 System Analysis ................................................................................................. 16
3.1.1 Requirement Analysis .................................................................................... 16
3.1.2 Feasibility Study ............................................................................................ 18
3.1.3 Object Modelling using Class and Object Diagrams ..................................... 19
3.1.4 Dynamic Modeling using State and Sequence Diagrams .............................. 22
3.1.5: Process Modelling using Activity Diagrams .................................................... 26
3.2 System Design ................................................................................................... 28
3.2.1 Refinement of Class, Object, State, Sequence, and Activity Diagram .......... 28

vii

3.2.2 Component Diagrams .................................................................................... 30
3.2.3 Deployment Diagram ..................................................................................... 32
3.3 Algorithm Details ............................................................................................... 33
Implementation And Testing .................................................................. 36
4.1 Implementation .................................................................................................. 36
4.1.1 Tools Used ..................................................................................................... 36
4.1.2 Implementation Details of Modules............................................................... 37
4.2 Testing................................................................................................................ 46
4.2.1 Testing cases for unit testing .......................................................................... 46
4.2.2 Testing case for unit testing of admin page ................................................... 46
4.2.3 Testing case for System testing ...................................................................... 47
4.3 Result Analysis .................................................................................................. 47
Conclusion And Future Recommendations ........................................... 50
5.1 Conclusion ......................................................................................................... 50
5.2 Lesson leant/Outcome ........................................................................................ 50
5.3 Future Recommendations .................................................................................. 50
REFERENCES ................................................................................................................. 51
APPENDIX ....................................................................................................................... 52








viii

## LIST OF ABBREVIATIONS
## CSS
## Cascading Style Sheet
FAQ      Frequently Asked Question
HTML      Hyper Text Markup Language
PHP   Hypertext Preprocessor
SQL  Structured Query Language
VSCode  Visual Studio Code












ix

## LIST OF FIGURES
Figure 3.1: Waterfall Methodology ................................................................................... 16
Figure 3.2: Use-Case Diagram ........................................................................................... 17
Figure 3.3: Class Diagram ................................................................................................. 19
Figure 3.4: Object diagram ................................................................................................ 21
Figure 3.5: State Diagram .................................................................................................. 22
Figure 3.6: Sequence Diagram ........................................................................................... 24
Figure 3.7: Activity Diagram ............................................................................................. 26
Figure 3.8: Refinement of Class Diagram ......................................................................... 28
Figure 3.9: Refinement of Object Diagram ....................................................................... 29
Figure 3.10: Component Diagram ..................................................................................... 30
Figure 3.11: Deployment Diagram .................................................................................... 32

x

## LIST OF TABLES
Table 4.1 Tools Used ............................................................................................................... 36
Table 4.2 Test cases of unit testing for login and logout operation ......................................... 46
Table 4.3 Test cases of unit testing of admin page .................................................................. 46
Table 4.4 Test cases of System testing .................................................................................... 47


## 11

## Introduction
## 1.1 Introduction
MedVault is  a  web-based  application  used  in  a  pharmacy  that  helps  automate  the  pharmacy
workflow.  This  includes  keeping  records  of  medications,  managing  the  orders and  sales  and
handling bills. Generally, the humans are not able to provide each and every specific detail about
stock, sales and many more. So, it plays a vital role to fulfill all these circumstances.
MedVault is  a  crucial  tool  for  integrates  multiple  functionalities  into  a  centralized  platform,
enhancing efficiency and accuracy. It enables pharmacy to monitor stock levels, reorder processes,
and track medication expiration dates, prices and its purpose.
The project is developed using HTML, CSS and Java Script for frontend and PHP for the backend.
In this project, the pharmacy can sign in their own account and can order and manage the medicines
according to their requirements.
1.2 Problem statement
Record keeping is considered as one of the difficult tasks in a pharmacy because most of the record
keepings  were  done  manually  which  led  to  a  lot  of  misplacements  of  medicines.  The  record  of
fresh batches couldn’t be kept in a safe manner. There was no proper record of medications
purchase and sold. Different problem like improper records of medicine and stock, miscalculation,
inefficient inventory improper record of data might occur while using manual file system. While
online  platforms  boast  a  wider  selection,  the  inability  to  physically  interact  with  the  product  or
receive  expert  advice  can  create  uncertainty  for  buyers,  especially  those  unfamiliar  with  PC
components.
## 1.3 Objectives
- To provide a system that keeps track of medicine in systematic way which lead to faster
access of medicine and resolve miscalculation of bills
- To develop an online store that allows pharmacies to explore and purchase medicine.
## 1.4 Scope And Limitation
## 1.4.1 Limitation
- Admin needs to approve the request of the pharmacy in order to sell the medicine.

## 12

## 1.4.2 Scope
- Users  can  register,  login,  and order medicine,  while  admins  can  manage medicines  and
order requests.
- Users can manage their stock in the inventory.
- User can complete their transaction with online payment.
## 1.5 Development Methodology
The development of MedVault was carried out using the Waterfall Methodology. The Waterfall
model is a linear and sequential software development approach in which each phase is completed
before  moving  to  the  next.  This  methodology  was  chosen  because  it  provides  a  structured
development   process,   proper   documentation,   and   systematic   project   management.   The
development  of  MedVault  consisted  of  several  phases,  including  requirement  analysis,  system
design,  implementation,  testing,  and  maintenance.  During  the  requirement  analysis  phase,  the
functional and non-functional requirements of the pharmacy management system were identified
and  analyzed.  In  the  system  design  phase,  the  overall  system  architecture  and  UML  diagrams,
including  the  Use  Case  Diagram,  Class  Diagram,  Object  Diagram,  State  Diagram,  Sequence
Diagram,  Activity  Diagram,  Component  Diagram,  and  Deployment  Diagram,  were  prepared  to
represent the structure and behavior of the system. The implementation phase involved developing
the   system   using   HTML,   CSS,   JavaScript,   PHP,   Apache   Server,   and   MySQL.   After
implementation, unit testing and system testing were conducted to identify and fix errors, ensuring
that the system functioned correctly and met the project objectives. Finally, the maintenance phase
allows  future  improvements,  bug  fixes,  and  feature  enhancements.  The  Waterfall  methodology
helped maintain a well-organized development process and ensured the successful completion of
the MedVault pharmacy management system.

## 1.6 Report Organization
## Chapter 1: Introduction
Chapter one introduces the concept of this project. It describes the problems that has been existing
and how its objective can tackle it. It also presents the scope and limitations of the project.
Chapter 2: Background study and literature review

## 13

This chapter focuses on the basic ideology of how this project will be build. It traces out the study
of different platforms and their workings.
Chapter 3: System analysis and design
This chapter describes the requirements gathering, feasibility study, and designing of the project.
It includes diagrams, functionality analysis, requirement gathering technique and process model.
Chapter 4:  Implementation and testing
This chapter is designed to give information about how the project has been implemented, what
kind of software and tools has been used and the type of testing that the project has gone through.
Chapter 5: Conclusion and future recommendation
This   chapter   includes   the   possible   outcome   of   this   project,   conclusion   and   future
recommendations.

## 14

Background Study and Literature Review
## 2.1 Background Study
Pharmacy  Management  System  is  a  software  application  designed  to  manage  and  automate  the
daily operations of a pharmacy. It helps in maintaining medicine records, managing stock levels,
handling sales and purchases, generating bills, and monitoring medicine availability. Traditional
pharmacy systems often rely on manual record keeping, which can lead to errors, miscalculations,
and  inefficient  inventory  management.  A  computerized  pharmacy  management  system  helps  to
reduce these problems by providing accurate and efficient data handling.
Inventory Management System is an important part of a pharmacy management system. It is used
to track medicine quantity, stock availability, expiry dates, and medicine details. Proper inventory
management  helps  pharmacies  maintain  sufficient  stock  levels  and  reduce  medicine  wastage
caused by expired products.
MedVault is developed as a web-based application. A web-based application is software that runs
on a web server and can be accessed through a web browser using the internet or local network.
Web  applications  are  platform  independent  and  provide  easier  accessibility  and  management
compared to traditional desktop applications.
The system uses a relational database management system (RDBMS) to store and manage data.
MySQL is used as the database in this project for storing medicine records, user details, orders,
and  inventory  information.  Databases  help  in  organizing  large  amounts  of  data  efficiently  and
securely.
For the frontend development of the project, HTML, CSS, and JavaScript are used. HTML is used
to  create  the  structure  of  web  pages,  CSS  is  used  for  styling  and  designing  the  interface,  and
JavaScript  is  used  to  make  the  system  interactive  and  dynamic.  PHP  is  used as  the  backend
programming language to handle server-side operations, process requests, and communicate with
the database.
The project follows the Waterfall Software Development Methodology. Waterfall methodology is
a  sequential  development  approach  where each  phase  such  as  requirement  analysis,  design,
implementation, testing, and maintenance is completed one after another in a structured manner.
This methodology helps maintain proper documentation and systematic project development.

## 15

## 2.2 Literature Review
The  development  of  MedVault  was  carried  out  after  studying  various  existing  pharmacy
management  systems  and  online  pharmaceutical  platforms.  Several  pharmacy  websites  and
inventory management systems were analyzed to understand their functionalities, advantages, and
limitations.  This  study  helped  in  identifying  the  essential  features  required  for  an  effective
pharmacy management system.
Existing platforms such as epharmacy.com.np [2] and mobimeds.com.np provide online medicine
purchasing services with features like medicine browsing, online ordering, inventory handling, and
customer  management.  These  systems  offer  user-friendly  interfaces  and  efficient  medicine
searching  facilities  that  improve  the  customer  experience.  They  also  provide  better  inventory
tracking and order management compared to traditional manual systems.
Similarly, pharmacy management projects developed using PHP and CodeIgniter framework [3]
were  also  reviewed  during  the  development  of  this  project.  These  systems  demonstrated
functionalities  such  as  medicine  stock  management,  billing  systems,  order  processing,  sales
tracking,  and  database  handling.  The  study  of  these  systems  provided  ideas  regarding  database
design, user authentication, and inventory management techniques.
Although  existing  systems  provide many  useful features,  some systems  are complex to  use  and
lack proper inventory tracking and management facilities for small pharmacies. MedVault aims to
overcome these limitations by providing a simple, user-friendly, and efficient web-based pharmacy
management  system.  The  system  integrates  inventory  management,  medicine  management,  and
order handling into a single platform to improve operational efficiency and reduce manual errors.
The   literature   review   helped   in   understanding   current   technologies,   identifying   system
requirements, and designing a better solution for pharmacy inventory and sales management.

## 16

System Analysis and Design
## 3.1 System Analysis
The  Waterfall  methodology  also  known  as  the  Waterfall  model  is  a  sequential  development
process that flows like a waterfall through all phases of a project (analysis, design, development,
and testing, for example), with each phase completely wrapping up before the next phase begins.

## Figure 3.1: Waterfall Methodology
The waterfall model is a traditional software development approach with a sequential, phase-based
structure. Each phase, like requirements gathering or testing, must be completed entirely before
moving on.  This  structured  approach  offers  clear  planning,  predictable  timelines,  and  ease  of
understanding.   However,   it   can   be   inflexible   for   adapting   to   changing   requirements   or
incorporating user feedback. The waterfall model is most suitable for smaller projects with well-
defined needs and established technologies
## 3.1.1 Requirement Analysis
Requirement analysis is the gathering of relevant requirement that will be used to develop a system.
Different methods have been adopted to gather requirement for this project.
i. Functional Requirements
The  system  will  enable  users  to  securely  log  in  and  navigate  the  platform,  providing  access  to
essential  features.  Users  will  have  the  capability  to  search  for  medicines  based  on  various
parameters  such  as  name,  category,  or  prescription,  and  proceed  with  secure  purchases  online.

## 17

Additionally, the system will incorporate a robust inventory management module, allowing users
to track stock levels, monitor expiry dates, and manage purchase orders.
Some of the functional requirements for this system are as follows:
- User can register.
- User can login to the system.
- User can be able to view the medicine.
- User can be able to purchase the medicine.
- Admin can view medicine.
- Admin can manage medicine.
- Admin can manage the orders of Users.

Figure 3.2: Use-Case Diagram
In the figure, the figure depicted a pharmacy management system where Customers were able to
place medicine orders, while Administrators managed the medicine. Lines connected the user to
the use cases they could perform. For example, the line connecting the User to "View Medicine"
indicated that a user could view medicine in the system.

## 18

ii. Non-Functional Requirements
The  non-functional  requirements  for MedVault focus  on  the  website's  performance  and  user
experience. This  includes software  qualities such as  performance,  security, usability, reliability,
and maintainability.
Some of the non-functional requirements of system are:
- The system must be designed for a user-friendly environment.
- The system must be secured.
Since the data is only accessible by authorized individuals, the system is safe from outside threats.
The system operates precisely and quickly because of its standardized database, which facilitates
quick operations.
## 3.1.2 Feasibility Study
It is the study of how well the system will function under the given constraints. It studies about
how  easy  is  it  to  build  a  system  under  given  constraints.  The  constraints  include  operational
feasibility, economic feasibility, and technical feasibility.
i. Technical Feasibility:
This system meets the technical feasibility as it will be using existing technologies like HTML,
CSS, JavaScript, PHP and MYSQL etc. as well as simple hardware specifications.
ii. Economic Feasibility:
MedVault will be feasible economically as the only needed will be a laptop, internet connection
and electricity.
iii. Operational Feasibility:
Since  the  system  promises  to  provide  easier  and  understandable  user  interface  as  well  as
responsiveness  when  used  in  another  device.  Thus,  the  proposed  system  will  be  operationally
feasible.
iv. Schedule Feasibility:
This  project  was  assigned  a  specific  duration  for  completion  and  it  was  successfully
accomplished within the designated timeframe. affirming its feasibility within the planned
timeline.

## 19

3.1.3 Object Modelling using Class and Object Diagrams

## Figure 3.3: Class Diagram
The  class  diagram  of MedVault represents the  overall  structure  of  the  pharmacy  management
system and shows the relationship between different classes used in the system. The Model class

## 20

is  an  abstract  base  class  that  provides  common  functionalities  to  other  classes.  The  User
class represents the customers or pharmacy users who can register, log in, view medicines, manage
stock,  and  place  orders.  The Admin class represents the  administrator  who  manages  medicines,
categories, pharmacies, orders, sales, and system settings. The Setting class stores configuration
details of the system. The Pharmacy class is responsible for managing pharmacy information and
medicine  stocks. The  Category  class  is  used  to  classify  medicines  into  different  categories  for
easier management and searching. The UserMedicine class stores medicine details such as name,
quantity, price, expiry date, and stock information. It is connected with both the Order and Sale
classes,  which  handle  medicine  ordering  and  sales transactions respectively.  The  relationships
between  these  classes show  how  medicines  are  categorized,  stocked,  ordered,  and  sold  within
the MedVault system, helping to automate and simplify pharmacy management operations.

## 21


Figure 3.4: Object diagram
The  object diagram  of  MedVault  represents  the  real-time  working  structure  of  the  pharmacy
management system by showing the objects created from different classes and the relationships
between them at a particular moment. Unlike the class diagram, which only shows the blueprint
of the system, the object diagram provides an example of how the system behaves during actual
operation.  It  contains  objects  such  as  User,  Admin,  Pharmacy,  Category,  UserMedicine,  Order,
and Sale along with their interactions. For example, a user object can log into the system, search
for medicines,  and  place an  order for a  specific medicine object. The admin object can manage
medicine  records,  update  stock  levels,  approve  orders,  and  monitor  sales  activities.  Medicine

## 22

objects are connected to category objects, showing that medicines belong to different categories
such as tablets, syrups, or antibiotics. Similarly, medicine objects are associated with pharmacy
objects to represent the storage and availability of medicines within the pharmacy inventory. The
order object stores information related to medicine purchases including order details, quantity, and
order  status,  while  the  sale  object  maintains  sales  records  and  transaction  details.  The  object
diagram  also  illustrates  how  data  flows  between these  objects  during  activities  like  medicine
ordering, billing, inventory  updating, and  sales processing. Overall,  the  object  diagram  helps in
understanding   the   practical   implementation   and   real-time   interaction   of   different   system
components within the MedVault pharmacy management system.
3.1.4 Dynamic Modeling using State and Sequence Diagrams


## Figure 3.5: State Diagram
The state diagram of MedVault represents the different states involved in the sales process of the
pharmacy  management  system  and  shows  how  a  sales  transaction  changes  from  one  state  to
another during its lifecycle. The diagram helps in understanding the flow of sales activities and the
conditions that cause transitions between different states. The process begins when a user selects

## 23

medicines  and  places  an  order  through  the  system.  At  this  stage,  the  sale  enters  the  initial  state
where the order details are recorded. After the order is placed, the system verifies the medicine
availability  and  stock  quantity.  If  the  medicines  are  available,  the  sale  moves  to  the  processing
state  where  the  admin  reviews  and  approves  the  order.  Once  approved,  the  billing  process  is
initiated and payment information is generated. After successful payment confirmation, the sale
enters the completed state where the transaction is finalized and the stock quantity is automatically
updated in the inventory. If there is any issue such as unavailable stock, payment failure, or order
cancellation, the sale may move to a cancelled or failed state. The sales state diagram therefore
illustrates  the  complete  lifecycle  of  a  sales  transaction,  from  order  placement  to  payment
completion  and  inventory  update,  ensuring  proper  sales  management  within  the  MedVault
pharmacy management system.

## 24


## Figure 3.6: Sequence Diagram
The sequence diagram of MedVault represents the step-by-step interaction between the user and
the system during the login process. It illustrates how authentication is performed and how access
is granted to authorized users. The process begins when the user opens the MedVault system and
enters their username or email along with the password on the login page. After the login button
is pressed, the system sends the entered credentials to the server for verification. The server then

## 25

checks  the  provided  information  with  the  records  stored  in  the  database.  If  the  username  and
password match the stored data, the system authenticates the user successfully and creates a session
for that user. Depending on the role of the user, such as admin or normal user, the system redirects
them to their respective dashboard or homepage. If the entered credentials are incorrect, the system
displays an error message and requests the user to enter valid login information again. The login
sequence diagram therefore demonstrates the complete flow of communication between the user
interface,  server,  and  database  during  the  authentication  process  in  the  MedVault  pharmacy
management system.



## 26

3.1.5: Process Modelling using Activity Diagrams

## Figure 3.7: Activity Diagram
The activity diagrams in MedVault are used to represent the workflow and sequence of activities
performed within the pharmacy management system. These diagrams help in understanding how
different  operations  are  carried  out  from  start  to  finish  through  various  actions  and  decision-

## 27

making processes. The process modelling using activity diagrams illustrates the flow of activities
such  as  user  registration,  login,  medicine  management,  inventory  handling,  order  placement,
payment  processing,  and  sales  management.  The  activity  flow  begins  when  a  user  accesses  the
system and logs in using valid credentials. After successful login, the user can browse medicines,
search for required products, add medicines to the cart, and place an order. The system then verifies
the  medicine  availability  and  forwards  the  order  request  to  the  admin  for  approval.  The  admin
reviews the order, updates stock information if necessary, and confirms the order. After approval,
the  payment  process  is  completed  and  the  billing  information  is  generated  automatically.  The
system  then  updates  the  inventory  and  stores  sales records  in  the  database.  Similarly,  separate
activity  diagrams  are  used  for  admin  operations  such  as  adding  medicines,  updating  medicine
details,  deleting  medicines,  and  managing  inventory.  Decision  nodes  in  the  activity  diagrams
represent  conditions  such as  successful  login,  medicine  availability,  valid  payment,  or  order
approval. Overall, the activity diagrams provide a clear representation of the dynamic workflow
and operational processes within the MedVault pharmacy management system.

## 28

## 3.2 System Design
3.2.1 Refinement of Class, Object, State, Sequence, and Activity Diagram

Figure 3.8: Refinement of Class Diagram
The refinement of diagrams in MedVault was carried out to improve the overall understanding,
structure, and functionality of the pharmacy management system. Different UML diagrams such
as class diagrams, object diagrams, state diagrams, sequence diagrams, and activity diagrams were

## 29

refined  to clearly  represent  the  behavior  and  interactions  of  the  system  components.  These
refinements helped in designing a more organized and efficient system architecture.
The  class  diagram  was  refined  to  clearly  define  the  classes  used  in  the  system,  including  User,
Admin,  Pharmacy,  Category,  UserMedicine,  Order,  Sale,  and  Setting  classes  along  with  their
relationships and responsibilities. The object diagram was refined to represent real-time instances
of these classes and demonstrate how objects interact during operations such as medicine ordering,
inventory management, and sales processing.

Figure 3.9: Refinement of Object Diagram
Similarly, the object diagrams were refined to represent the various states involved in processes
such as sales management and order handling. These diagrams illustrate how the system transitions
from  one  state  to  another  during  activities  like  order  placement,  payment  processing,  approval,
and  completion.  The  sequence  diagrams  were  refined  to  clearly  show  the  interaction  between
users, system interfaces, servers, and databases during operations such as login authentication and
medicine management.

## 30

Overall, the refinement of these diagrams helped in improving system analysis, simplifying system
design,  and  providing  a  clearer  representation  of  the  structure  and  workflow  of  the  MedVault
pharmacy management system.
## 3.2.2 Component Diagrams


## Figure 3.10: Component Diagram
The component diagram of MedVault represents the overall software architecture of the pharmacy
management system by showing the different components of the system and their interactions with
each  other.  It  illustrates  how  various  modules  are  organized  and connected  to  perform  specific
functionalities  within  the  application.  The  diagram  mainly  consists  of  frontend  components,
backend components, database components, and server components. The frontend component is
developed  using  HTML,  CSS,  and  JavaScript,  which  provides  the  user  interface  for  users  and
administrators to interact with the system. The backend component is developed using PHP, which
handles  server-side  processing,  business  logic,  authentication,  medicine management,  inventory
handling, and order processing. The database component uses MySQL to store and manage data

## 31

such as user information, medicine records, sales details, inventory data, and order history. The
Apache  server  acts  as  the  web  server  that  hosts  the  application  and  manages  communication
between the client interface and the backend system. The component diagram also demonstrates
how  modules  such  as  login  management,  medicine  management,  inventory  management,  sales
management,  and  order  management  interact  with  the  database  and  server to  perform  system
operations efficiently. Overall, the component diagram provides a high-level view of the structure
and  organization  of  the  MedVault  pharmacy  management  system  and  explains  how  different
software components work together to ensure smooth functionality.

## 32

## 3.2.3 Deployment Diagram

## Figure 3.11: Deployment Diagram
The  deployment  diagram  of  MedVault represents  the  physical  architecture  of  the  pharmacy
management  system  and  illustrates  how  the  software  components  are  deployed  on  hardware
devices and servers. It shows the relationship between the client devices, web server, application
server, and database server involved in the system. In MedVault, users and administrators access
the  system  through  client  devices  such  as  computers,  laptops,  or  mobile  devices  using  a  web
browser. The client devices send requests to the web server, which is managed using the Apache
server. The web server hosts the MedVault application and processes requests through the backend

## 33

## WMA =
## 푖=0

developed  in  PHP.  The  backend  communicates  with  the  MySQL  database  server  to  store  and
retrieve  information  related  to  medicines,  users,  inventory, sales,  and  orders.  The  frontend
interface developed using HTML, CSS, and JavaScript is displayed to users through the browser,
allowing   interaction   with   the   system.   The   deployment   diagram   also   demonstrates   the
communication  flow  between  different  hardware and  software  components  over  a  network
connection. Overall, the deployment diagram provides a clear understanding of how the MedVault
pharmacy management system is physically deployed and how different components interact to
ensure proper system functionality and accessibility.
## 3.3 Algorithm Details
## 1.  Moving Average Algorithm
A  moving  average  algorithm  calculates  the  average  of  a  dataset  over  a  specific
period,   and   as   new   data   points   are   added,   the   average   "moves"   forward,
recalculating the average using the latest data
## How It Works
- Purpose: The moving average algorithm smooths out short-term fluctuations in
sales data to reveal longer-term trends.
## 2. Parameters:
- data: An array of sales amounts
- windowSize: The number of data points to include in each average calculation
(set to 3 in your implementation)
## 3. Algorithm Steps:
- For each data point at index i, the algorithm:
- Determines the starting index for the window (start = Math.max(0, i
- windowSize + 1))
- Calculates the sum of all values within the window
- Divides the sum by the number of values in the window
- Adds the result to the output array
- Array data is then shown in chart


## • Mathematical Expression:

## ∑
## 푛−1

## 푤 ∗ 푃

## 34

## ∑
## 푤
## 푖=0

## 푛−1
## 푖=0


## Where:

- WMA is the weighted moving average at time t.
- n is the window size
- w is the weight assigned to data point at position i.
- P is the data point at time t-i.
## •
## ∑
## 푛−1

푤 is the sum of all weights


## 2.  Anomaly Detection
Anomaly detection is the process of identifying rare or unexpected patterns in data that
deviate significantly from the norm.
## How It Works
- Purpose: The moving average algorithm smooths out short-term fluctuations in
sales data to reveal longer-term trends.
## 2. Parameters:
- data: An array of sales amounts
- threshold: The z-score threshold for anomaly  detection (default is  2, meaning
values more than 2 standard deviations from the mean are considered anomalies)
## 3. Algorithm Steps:
- Calculate the mean of the data
- Calculate the standard deviation of the data
- For each data point, calculate its z-score (the number of standard
deviations it is from the mean)
- Identify data points with z-scores exceeding the threshold as anomalies
- Return the indices of the anomalous data points



## • Mathematical Expression:


## 35


## Where:
## 푧 = 푥 − 휇


## 휎

- z is the z-score for data point i
- x is the value of data point i
- 휇 is the mean of the dataset
- 휎 is the standard deviation of the dataset
A data point is considered an anomaly if:
## |
## 푧
## |
## > 푡ℎ푟푒푠ℎ표푙푑

## Where:

- 푡ℎ푟푒푠ℎ표푙푑 is typically set to 2 or 3 standard deviations.

## 36

## Implementation And Testing
## 4.1 Implementation
## 4.1.1 Tools Used
Different tools are used during different software development phases. As, for the frontend,
we  used  HTML,  CSS,  and  JavaScript  to  create  interactive  user  interface.  And  for  the
backend, PHP is used to handle server-side operation and database interaction.  To manage
and  store  data,  MySQL  is  used.  Microsoft word  is  used  for  writing  report,  proposal  and
Visual Studio Code (VSCode) is used for writing the code.
## Table 4.1 Tools Used
Frontend HTML, CSS, JavaScript
Backend PHP
Database MySQL
## Server Apache

## Frontend:
- HTML:  HTML is used here to create the structure and content of web pages
and to define the layout, headings, paragraphs, images, and other elements
that make up our webpage.
- CSS: CSS is used here to control the presentation and appearance of the web
pages.  Also  to  define  the  fonts,  colors,  layouts,  and  styles,  ensuring
consistent and visually appealing designs.
- JavaScript: JavaScript is used her to make the website interactive and handle
user events.
## Backend:
- PHP: PHP  is  used  in MedVault to  handle server-side operations  and
database interaction. PHP a server–site scripting language has been used to
connect html files into database in this system.

## 37

## Database:
- MYSQL: MYSQL an open-source relational database management system is used
for storing the database in this system.
## Server:
- Apache: The  Apache  HTTP  Server  is  a  free  and  open-source  cross-platform
web server software, released under the terms of Apache License 2.0.
4.1.2 Implementation Details of Modules
The different modules provided are:
## Module 1: View Product
This module provides an interface that allows users to view product. This module also
provides different product recommendation.
<div class="row bg-white py-4 px-3 gy-4 rounded">
<div class="row px-3">
## <?php
alertmessage();
## ?>
## </div>
<h1 class="h3 m-0 fw-bold">Products</h1>
## <?php
$result = getAllProducts('tbl_medicine');
while ($row=mysqli_fetch_assoc($result)){
## $product_id= $row['medicine_id'];
## $product_name=$row['medicine_name'];
## $product_description=$row['medicine_description'];
## $product_image=$row['images'];
## $product_price=$row [ 'price'];
## ?>
<div class="col">
<div class="card" style="width: 15rem;">


## 38

## Module 2: Login
This  module  is  responsible  for  validating  the  type  of  user  and  displaying  options
according to the role of users.
<img src="<?=$product_image?>" class="card-img-top" style="height:
250px;" alt="<?=$product_name?>">
<div class="card-body h-100 ">
<div class="product-card " role="button" data-
href="product.php?medicine_id=<?= $product_id ?>">
<a href="product.php?medicine_id=<?= $product_id ?>"><h5
class="card-title h6"><?=$product_name?></h5></a>
<p class="card-text h5 text-danger fw-semibold mb-4 ">Rs.
## <?=$product_price?>.00</p>
## </div>
<a href="php/add-to-cart.php?add_to_cart=<?=$product_id?>"
class="btn btn-danger w-100 py-2">Add to cart</a>
## </div>
## </div>
## </div>
## <?php
## }
## ?>
## </div>
if(isset($_POST['signIn']))
## {
$emailInput = validate($_POST['email']);
$passwordInput = validate($_POST['password']);
$email = filter_var($emailInput,FILTER_SANITIZE_EMAIL);
## $password=
filter_var($passwordInput,FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_H
## IGH);
if($email != '' && $password != ''){
$query = "SELECT * FROM $admin_table WHERE email = '$email'";
$result = mysqli_query($conn,$query);


## 39


if($result)
## {
if(mysqli_num_rows($result) == 1)
## {
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
if(password_verify($passwordInput, $row['password'])) {
if($row['role'] == 'admin')
## {
$_SESSION['auth'] =true;
$_SESSION['loggedInUserRole'] = $row['role'];
$_SESSION['loggedInUser'] = [
## 'name' => $row['name'],
## 'user_id' =>  $row['user_id'],
## 'email' => $row['email']
## ];
redirect('../proj-back/admin.php','Logged In Successfully');
} else{
$_SESSION['auth'] =true;
$_SESSION['loggedInUserRole'] = $row['role'];
$_SESSION['loggedInUser'] = [
## 'name' => $row['name'],
## 'user_id' =>  $row['user_id'],
## 'email' => $row['email']
## ];
redirect('home.php','Logged In Successfully');
## }
## }
else
## {
redirect ('login.php','Invalid Email or Password');
## }
## }


## 40


## Module 3: Add Product
This module allows admin to add product.
else
## {
redirect('login.php','Invalid Email or Password');
## }
## }
else
## {
redirect('login.php','Invalid Email');
## }
## }
## }
if(isset($_POST['add-medicine'])){
$medicine_name = $_POST['name'];
$manufacturer_name = $_POST['manufacturername'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$exp_date = $_POST['exp_date'];
$formatted_Date = date("Y-m-d", strtotime($exp_date));
$dosage = $_POST['dosage'];
$imagename = $_FILES['images']['name'];
$fileExt = explode('.',$imagename);
$fileActualExt = strtolower(end($fileExt));
$fileNameNew = uniqid('', true).".".$fileActualExt;
$fileError = $_FILES['images']['error'];
$fileSize = $_FILES['images']['size'];
if (!preg_match("/^[a-zA-Z-' ]*$/",$medicine_name)) {
redirect('medicine-create.php','Only letters and white space allowed');
## }

## 41


if (!preg_match("/^[a-zA-Z-' ]*$/",$manufacturer_name)) {
redirect('medicine-create.php','Only letters and white space allowed');
## }
if(!is_numeric($price)) {
redirect('medicine-create.php','Invalid Price Number');
## }
$allowed = array('jpg', 'jpeg', 'png');
if (!in_array($fileActualExt, $allowed)) {
redirect('medicine-create.php','You cannot upload files of this type!');
## }
if ($fileError === 0) {
if ($fileSize < 1000000) {
## $upload_dir = "../uploaded_img/";
// Create the directory if it doesn't exist
if (!file_exists($upload_dir)) {
mkdir($upload_dir, 0777, true);
## }
$file_tmp = $_FILES['images']['tmp_name'];
$fileDestination = $upload_dir.$fileNameNew;
if(move_uploaded_file($file_tmp, $fileDestination)){
echo "Image $file_name uploaded successfully!<br>";
} else {
redirect ('medicine-create.php','Error uploading image');
## }
$query="INSERT INTO tbl_medicine
## (medicine_id,medicine_name,manufacturer,price,quantity,expiration_date,dosage,
images)
VALUES('','$medicine_name','$manufacturer_name','$price','$quantity','$formatted_
Date','$dosage','../uploaded_img/$fileNameNew')";
$data = mysqli_query($conn,$query);
if($data) {
redirect('medicine-create.php','Medicine Added Successfully');

## 42


## Module 4: Update Product
This module allows admin to update product.
else{
redirect('medicine-create.php','Could Not Add Medicine');
## }
## }else {
redirect('medicine-create.php','Your file is too big!');
## }
## }
else{
redirect('medicine-create.php','Could Not Add Medicine');
## }
## }
if(isset($_POST['update-medicine'])){
$medicine_id = $_POST['update_id'];
$medicine_name = $_POST['name'];
$manufacturer_name = $_POST['manufacturername'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$exp_date = validate($_POST['exp_date']);
$formatted_Date = date("Y-m-d", strtotime($exp_date));;
$dosage = $_POST['dosage'];

if (!preg_match("/^[a-zA-Z-' ]*$/",$medicine_name)) {
redirect('medicine-create.php','Only letters and white space allowed');
## }
if (!preg_match("/^[a-zA-Z-' ]*$/",$manufacturer_name)) {
redirect('medicine-create.php','Only letters and white space allowed');
## }

## 43


if(!is_numeric($price)) {
redirect('medicine-create.php','Invalid Price Number');
## }
if(!empty($_FILES['images']['tmp_name'])) {
$imagename = $_FILES['images']['name'];
$fileExt = explode('.',$imagename);
$fileActualExt = strtolower(end($fileExt));
$fileNameNew = uniqid('', true).".".$fileActualExt;
$fileError = $_FILES['images']['error'];
$fileSize = $_FILES['images']['size'];
$allowed = array('jpg', 'jpeg', 'png');
if (!in_array($fileActualExt, $allowed)) {
redirect('medicine-create.php','You cannot upload files of this type!');
## }
if ($fileError === 0) {
if ($fileSize < 1000000) {
$imagequery = "UPDATE tbl_medicine SET
images = '../uploaded_img/$fileNameNew'
WHERE medicine_id='$medicine_id'";
$imagedata = mysqli_query($conn,$imagequery);
## $upload_dir = "../uploaded_img/";
if (!file_exists($upload_dir)) {
mkdir($upload_dir, 0777, true);
## }
$file_tmp = $_FILES['images']['tmp_name'];
$fileDestination = $upload_dir.$fileNameNew;
if(move_uploaded_file($file_tmp, $fileDestination)){
echo "Image $file_name uploaded successfully!<br>";
} else{
redirect('medicine-display.php','Error uploading image!');
## }

## 44



## }else {
redirect('medicine-display.php','Your file is too big!');
## }
## }else {
redirect('medicine-display.php','Could Not Update Image');
## }
## }
$query = "UPDATE tbl_medicine SET
medicine_name ='$medicine_name',
manufacturer ='$manufacturer_name',
price ='$price',
quantity ='$quantity',
expiration_date = '$formatted_Date',
dosage = '$dosage'
WHERE medicine_id='$medicine_id'";
$data = mysqli_query($conn,$query);
if($data){
redirect('medicine-display.php','Medicine Added Successfully');
## }
else{
redirect('medicine-display.php','Could Not Update Medicine');
## }
## }

## 45

## Module 5: Delete Product
This module allows admin to delete product.

if(is_numeric($paraResult)){
$medicine_id = validate($paraResult);
$medicine = getById('tbl_medicine','medicine_id', $medicine_id);
if($medicine['status'] == 200){
$medicinedelete = deleteQuery('tbl_medicine','medicine_id', $medicine_id);
if($medicinedelete){
redirect('medicine-display.php','Medicine Removed Successfully');
## }else{
redirect('medicine-display.php','Something Went Wrong!');
## }
## }else{
redirect('medicine-display.php','Medicine Not Found');
## }
## }else{
redirect('medicine-display.php', $paraResult);
## }

## 46

## 4.2 Testing
Testing  includes  unit  testing  to  ensure  individual  components  function  correctly,  system
testing  to  validate  overall  system  behavior,  and various  test  cases  to  cover  functionality,
performance, and user experience.
4.2.1 Testing cases for unit testing
Testing Scenario: Login and Logout Process
Table 4.2 Test cases of unit testing for login and logout operation
## Test
## Case
## Steps Expected Results Status
1 Enter  valid  username  and  password,
then press login button
User   should   be   redirected   to   the
dashboard
## Pass
2 Enter invalid username or password User  should  stay  on  the  login  page
with an error message
## Pass
3 Leave username   or   password   field
blank
Alert  box  should  appear  indicating
blank fields
## Pass
4 Press logout button User should be redirected to the login
page
## Pass

4.2.2 Testing case for unit testing of admin page
## Testing Scenario: Admin Login
Table 4.3 Test cases of unit testing of admin page
## Test
## Case
## Steps Expected Results Status
1 Login as an admin User   should   be   redirected   to   the   admin
dashboard
## Pass
2 Add  a  new product with  all
required details
Product should  be  added  to  the  system  and
displayed in the product list
## Pass
3 Add   a   new user with   all
required details
User should   be   added   to   the   system   and
displayed in the User list
## Pass

## 47

4 Approve the user order Order should be approved and displayed in the
order completed list.

## Pass

4.2.3 Testing case for System testing
Table 4.4 Test cases of System testing
## Test
## Case
## Steps Expected Results Status
1 Login  as valid  email
and password
The user should be taken to home page with all the set of
option provided as per their role
## Pass
2 Click on a product The  user  should  be  taken  to  product  page  with  all  its
details.
## Pass
3 Type  on  the  search
bar
The search bar should asynchronously load all the video
with the provided keyword from the database
## Pass
4 Cart function The user should be able to add products in their cart Pass

## 4.3 Result Analysis
The result analysis evaluates the two analytics features implemented in MedVault: daily
sales anomaly detection and the weighted moving average (WMA) trend line. The anomaly
detector is evaluated as a binary classifier, while WMA is described as a smoothing and
short-term forecasting aid.

### 4.3.1 Anomaly Detection Evaluation

For each pharmacy, sales are grouped by calendar day. The detector calculates the mean
and population standard deviation of the daily totals. A day is classified as an anomaly
when its absolute z-score is greater than 2.0:

\[
z_i = \frac{|x_i-\mu|}{\sigma}
\]

The evaluation used the deterministic analytics demo data from 4 July to 5 September
2026. Three pharmacies and 64 days produced 192 pharmacy-day observations. The seeded
dataset contains eight known anomalies: five high-sales spikes and three low or zero-sales
dips. These known labels were compared with the detector output.

#### Confusion Matrix

| Actual class / Predicted class | Anomaly | Normal |
|---|---:|---:|
| Anomaly | 7 (TP) | 1 (FN) |
| Normal | 0 (FP) | 184 (TN) |

The matrix contains all 192 evaluated observations (7 + 1 + 0 + 184 = 192).

#### Classification Metrics

\[
\text{Accuracy}=\frac{TP+TN}{TP+TN+FP+FN}=\frac{7+184}{192}=99.48\%
\]

\[
\text{Precision}=\frac{TP}{TP+FP}=\frac{7}{7}=100.00\%
\]

\[
\text{Recall}=\frac{TP}{TP+FN}=\frac{7}{8}=87.50\%
\]

\[
F1=2\times\frac{\text{Precision}\times\text{Recall}}
{\text{Precision}+\text{Recall}}=93.33\%
\]

The detector produced no false positives in this controlled dataset, so every flagged day
was a known injected anomaly. It detected seven of the eight anomalies and missed one
low-sales event. Accuracy is high partly because normal observations are much more
common than anomalies; therefore, recall and F1-score provide a more informative view
of anomaly-detection performance.

### 4.3.2 Weighted Moving Average Results

The sales analysis page displays a three-day WMA trend line calculated with weights
`[0.5, 0.3, 0.2]`. The weighted line smooths daily fluctuations and helps pharmacy users
identify the recent direction of sales and estimate near-term demand. WMA is a numeric
forecasting output rather than a binary classifier, so confusion-matrix metrics do not
apply to it. A separate hold-out evaluation using MAE, RMSE, or MAPE would be required
before claiming a WMA forecast-accuracy score.

These results demonstrate that the anomaly detector works on the labelled demonstration
dataset. Performance on production data may differ, and future evaluation should use
manually reviewed historical pharmacy records with independently verified anomaly labels.

## 50

## Conclusion And Future Recommendations
## 5.1 Conclusion
This project successfully developed MedVault, a web-based pharmacy management system
that  helps  automate  pharmacy  operations  such  as  medicine  management,  inventory
tracking,  order  processing,  and  sales  management.  The  system  was  developed  using
HTML,   CSS,   JavaScript,   PHP,   and   MySQL   by   following   the Waterfall   Software
Development Methodology. MedVault provides an efficient and user-friendly platform for
managing  pharmacy  records,  reducing  manual  errors,  and  improving  the  accuracy  of
inventory and sales management. The objectives of the project were successfully achieved
by  providing  features  such  as  user  authentication,  medicine  management,  inventory
control, and order management. Overall, the system offers a reliable solution for modern
pharmacy management and can help pharmacies improve their operational efficiency.
5.2 Lesson leant/Outcome
The  development  of  MedVault  provided  valuable  practical  experience  in  software
development and project management. Throughout the project, knowledge gained during
the Bachelor of Computer Application program was applied in designing, developing, and
testing  a  real-world  web  application.  Technical  skills  in  HTML,  CSS,  JavaScript,  PHP,
MySQL, and Apache Server were significantly improved. Experience was also gained in
database management, system analysis, UML diagram design, testing, documentation, and
debugging. The project enhanced problem-solving, time management, communication, and
documentation   skills   while   demonstrating   the   importance   of   proper   planning   and
systematic  software  development  using  the  Waterfall  methodology.  Overall,  this  project
strengthened  both  technical  and  professional  skills  that  will  be  beneficial  for  future
software development projects.
## 5.3 Future Recommendations
MedVault can be further improved by widening the target user base to ordinary people. The
users should have functionality to upload their prescription can also have subscriptions as
well as notification facility.



## REFERENCES

[1]  C. F. Inventory, "CFBlog," 16 September 2023. [Online]. Available:
https://cashflowinventory.com/blog/inventory-discrepancies/.
[2]  "ePharmacy," [Online]. Available: https://www.epharmacy.com.np.
[3]  oretnom23, "sourcecodester," June10 2022. [Online]. Available:
https://www.sourcecodester.com/php-codeigniter-pharmacy-sales-and-inventory-
management-system-project.






## APPENDIX
## Homepage:









Login page

Admin page



