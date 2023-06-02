<a name="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Summary</summary>
  <ol>
    <li>
      <a href="#%EF%B8%8F-an-easier-way-to-manage-your-catalog"> ✔️ An easier way to manage your catalog!</a>
       <ol>
    <li>
      <a href="#-quick-edit-products"> ⚡ Quick edit products</a>
    </li>
         <li>
      <a href="#-quick-create-configurables"> ⚡ Quick create configurables</a>
    </li>
         <li>
      <a href="#%EF%B8%8F-display-product-image-in-admins-grid"> 🖼️ Display product image in admin's grid</a>
    </li>
         <li>
      <a href="#%EF%B8%8F-bulk-delete-categories"> ✖️ Bulk delete categories</a>
    </li>
         <li>
      <a href="#-quick-edit-products"> ⚡ Quick edit products</a>
    </li>
      </ol>
    </li>
    <li>
      <a href="#%EF%B8%8F-a-best-way-to-organize-your-catalog"> ✔️ A best way to organize your catalog!</a>
       <ol>
    <li>
      <a href="#-new-sort-orders-available"> 📦 New sort orders available</a>
    </li>
         <li>
      <a href="#-out-of-stock-products-last"> 📦 Out of stock products last</a>
    </li>
      </ol>
    </li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>


## 🔧 Installing

Copy all files to it's respective path in our Magento root folder

<!-- ABOUT THE PROJECT -->
## ✔️ An easier way to manage your catalog!

This module adds several tools to your Magento 1 that make time-consuming tasks easier and unecessary clicks avoided. It also adds new features that can help you and your customers to "go directly to what matters".

### ⚡ Quick edit products

Most products are dynamic, we need to change it's price and stock frequently. Thinking in that, this module adds a shortcut in your admin product's grid that allows you to quickly update this info. Just click in the pencil icon, change the value and save it!

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/5d0142e8-cac5-4be4-a733-3890b6809855)

This also is applied to configurable's associated products grid, so you can quickly update their values after the creation:

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/6e9b8f23-29d5-4a78-897c-e81c92e653f5)

[DEV NOTES]

This 'quick edit' function is handled by the renderer `MD_AdvancedCatalog_Block_Adminhtml_Catalog_Product_Edit_Renderer_Quick`. It's possible to use it in another fields and/or grid types.

### ⚡ Quick create configurables

Creating configurable products can be a pain in the ass. Pre-creating attributes, create one associated product per time... It's a waste of time. Want to do it faster? Enable the `Quick Create Configurable` option in `System -> Configuration -> Advanced Catalog -> [Admin] Create Product` and create how many variations for your product as you wish!

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/d59244c4-1c1b-4910-95bd-e43d65bd5999)

You only need to save the configurable product and all associated products will be created, even if their attribute's values doesn't exist!
e.g: if color `Red` does not exists in the attribute `color`, it will be automatically created.

#### - Setting custom attributes to associated products

It's also possible to specify custom attributes to be setted to all newly created simple products at `System -> Configuration -> Advanced Catalog -> [Admin] Create Product -> [Quick Create Configurable] Custom Attributes`. For example, by enabling the attribute `manufacturer`, it will be shown in a new section called 'Custom Attributes':

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/342440fc-57d4-4b92-8b67-e1d794ac4901)

#### - Pre-creating configurable's attribute 

Instead of going to `Catalog -> Attributes -> Manage Attributes`, creating your new attribute (say `color`) and adding it to a group, you can simply provide the new attribute info in the new section added to configurable product's creation and hit 'Save'. The new attribute will be then available to use!

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/4b7ebb6e-7ed5-40e2-a6f2-8a6132476102)

### 🖼️ Display product image in admin's grid

This feature makes it better to visualize your products at the admin grid by showing their images as a miniature:

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/7a7989e0-ce1e-405b-823b-c3583d300000)

You can enable it at `System -> Configuration -> Advanced Catalog -> [Admin] Product Listing -> Display Image` and select which image field (Base Image, Small Image or Thumbnail) will be used in the display.

[DEV NOTES]

This module adds jQuery to your admin panel.

### ✖️ Bulk delete categories

Need to delete multiple categories and don't want to do the one-by-one process? Go to `Catalog -> Manage Categories` and click in the newly added 'Bulk Delete Categories' button. Then, just select which categories you want to delete and confirm it!

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/7fda7598-e824-4c81-b7ae-f05e206ff0b1)

## ✔️ A best way to organize your catalog

Creating products efficiently is good, but nothing matters if your customers can't flow through them in a consice and direct way. Here are some features available in this module that will improve your customers navigation:

### 📦 New sort orders available

Besides the default sort orders available (by position, attribute, etc), **5** new options can be added to catalog's sorting in your category's page and/or search results:
- Most Recent;
- Name A-Z;
- Name Z-A;
- Higher Price;
- Lowest Price;

![image](https://github.com/matheus-delazeri/advanced-catalog-magento1/assets/55641441/36ed6eb4-616b-456c-9c47-465df109e069)

It's possible to toggle this sort orders at `System -> Configuration -> Advanced Catalog -> Product Listing -> [Additional] Sort by`.

### 📦 Out of stock products last

Rarely are the cases where customers want to see out of stock products alongside available ones. To fix that, you can enable `System -> Configuration -> Advanced Catalog -> Product Listing -> Out of Stock last` to onl show product's out of stock at the end of your category's page and/or search results.

<p align="right">(<a href="#readme-top">voltar ao topo</a>)</p>

## Contact

[![Linkedin][linkedin-shield]][linkedin-matheus]

<p align="right">(<a href="#readme-top">voltar ao topo</a>)</p>


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/matheus-delazeri/advanced-catalog-magento1.svg?style=for-the-badge
[contributors-url]: https://github.com/matheus-delazeri/advanced-catalog-magento1/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/matheus-delazeri/advanced-catalog-magento1.svg?style=for-the-badge
[forks-url]: https://github.com/matheus-delazeri/advanced-catalog-magento1/network/members
[stars-shield]: https://img.shields.io/github/stars/matheus-delazeri/advanced-catalog-magento1.svg?style=for-the-badge
[stars-url]: https://github.com/matheus-delazeri/advanced-catalog-magento1/stargazers
[issues-shield]: https://img.shields.io/github/issues/matheus-delazeri/advanced-catalog-magento1.svg?style=for-the-badge
[issues-url]: https://github.com/matheus-delazeri/advanced-catalog-magento1/issues
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-matheus]: https://www.linkedin.com/in/matheus-delazeri-souza
