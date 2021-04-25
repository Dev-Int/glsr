Configuration
=============

For the first time you enter into you application, you have to configure it.

## Create a company

The company is the owner of the application. The restaurant that wants to manage its stocks.

Information needed are:

- Company name
- address (address, zipcode, town, country)
- phone number
- facsimile number
- email address
- contact name
- cellphone of this contact

**_@todo: verify the need for an additional entity for the local and the currency_**

Only one company can be created for the application.

## Configure the application

For a good work on the application, it's necessary to add 

- the locale 
- the currency
  
- the way to enter the inventory (continuously or by storage area)
  (_perhaps just need in Inventory Bounded Context_)
- the calculation of the inventory (FIFO or LIFO)
  (_perhaps just need in Inventory Bounded Context_)

**_@todo: verify the need for an additional entity for the local and the currency_**

## Create the Logistics Families

This section deals with the most important elements for sorting Articles. As for categories, it is a tree structure.

The first level is 'Alimentary' or not
```
Alimentary              |- Poultry
    |          |- Meet -|- Beef
    |          |        |- Pig  
    |          |
    |- Frozen -|- Fruits and vegetables
    |          |- BOF (Butter egg cheese in french)
    |
    |                  |- Poultry
    |         |- Meet -|- Beef
    |         |        |- Pig
    |         |
    |- Fresh -|- Fruits and vegetables
...
```
For each Family:
- label
- parent or not
- children or not

## Create the Storage Areas

You have to create the different storage locations in the restaurant. This functionality is necessary for the Inventory.

The entry of the inventory can be done by storage area or continuously.

- name of area
- (_? is it necessary_) slug

## Create units

The units are necessary for the use of the articles.
- Their packaging for the Inventory and the Order.
- Their unpacking for the recipe sheets.

For each unit: 
- name
- abbreviation
- (_? is it necessary_) slug

## Create VAT rates

This part is necessary for the Order and Sale sections.

## Create Suppliers

Information needed are:

- Company name
- address (address, zipcode, town, country)
- phone number
- facsimile number
- email address
- contact name
- cellphone of this contact

...and for the supplier:
- delivery delay (the number of day after the order)
- order days (an array of days when orders can be placed with the supplier)
- active (for soft delete)
- articles (an array of the Articles of this supplier)


## Create Articles

The Articles are the center of the application. All work with or around Articles.

For each Article:
- label
- supplier
- logistic family (depends on supplier's logistic family or its children)
- quantity
- unit
- packaging (details of different quantity and unit of each package)
- minimum stock
- zone storage
- active (for soft delete)
- price
