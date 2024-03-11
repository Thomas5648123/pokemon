# PokeAPI Integration Module for Magento 2

## Objective

The objective of this module is to integrate the PokeAPI (https://pokeapi.co/docs/v2) into a Magento 2 store. This integration allows the store to dynamically fetch and display Pokémon-related information for products.

## Features

- Dynamically fetch Pokémon information based on the product's assigned Pokemon name attribute.
- Create a new product attribute named "Pokemon Name" for mapping products to specific Pokémon.
- Display Pokémon name and image on product listing and detail pages.
- Utilize caching mechanisms to avoid unnecessary API calls.
- Invalidate cache when necessary (e.g., product data update).

## Configuration

1. Navigate to Stores > Configuration > Catalog > Pokemon Configuration

2. Enable/disable the PokeAPI integration.

3. Configure the PokeAPI endpoint URL.

## Usage

1. Create or edit a product in the Magento 2 admin panel.

2. Assign a Pokémon name to the "Pokemon Name" attribute.

3. Save the product.

4. The module will dynamically fetch Pokémon information based on the assigned Pokémon name and display it on the product listing and detail pages.

## Caching

The module implements caching mechanisms to optimize performance and reduce API calls. Cached Pokémon data is stored based on the product's Pokémon name attribute.
