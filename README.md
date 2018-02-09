[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/YelpAPI/functions?utm_source=RapidAPIGitHub_YelpFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# YelpAPI Package
Search local businesses geographically with Yelp database.
* Domain: [yelp.com](https://yelp.com)
* Credentials: appId, appSecret

## How to get credentials: 
0. Sign up or Log in to [Yelp](https://www.yelp.com) 
1. Go to [Create App](https://www.yelp.com/developers/v3/manage_app)
2. In the create new app form, enter information about your app accordingly, and then agree to Yelp API Terms of Use and Display Requirements.
3. Click the submit button and you should receive your Client ID and Client Secret.
4. Use your Client ID and Client secret to call the [getAccessToken endpoint](https://rapidapi.com/package/YelpAPI/functions/getAccessToken)

## Custom datatypes: 
 |Datatype|Description|Example
 |--------|-----------|----------
 |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
 |Map|String which includes coordinate coma separated|```50.37, 26.56```
 |List|Simple array|```["123", "sample"]``` 
 |Select|String with predefined values|```sample```
 |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```
 

## YelpAPI.getAccessToken
Allows to get an access token.

| Field    | Type       | Description
|----------|------------|----------
| appId    | credentials| Required: Your App ID obtained from Yelp.
| appSecret| credentials| Required: Your App Secret obtained from Yelp.

## YelpAPI.getBusinesses
This endpoint returns up to 1000 businesses based on the provided search criteria. It has some basic information about the business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| term       | String| Optional: Search term (e.g. "food", "restaurants"). If term isn’t included we search everything. The term keyword also accepts business names such as "Starbucks".
| location   | String| Optional: Required if either coordinate is not provided. Specifies the combination of "address, neighborhood, city, state or zip, optional country" to be used when searching for businesses.
| coordinate | Map   | Optional: Required if location is not provided. coordinate of the location you want to search near by coma separated.
| radius     | Number| Optional: Search radius in meters. If the value is too large, a AREA_TOO_LARGE error may be returned. The max value is 40000 meters (25 miles).
| categories | String| Optional: Categories to filter the search results with. [See the list of supported categories](https://www.yelp.com/developers/documentation/v3/all_category_list). The category filter can be a list of comma delimited categories. For example, "bars,french" will filter by Bars and French. The category identifier should be used (for example "discgolf", not "Disc Golf").
| locale     | String| Optional: Specify the locale to return the business information in. [supported locales](https://www.yelp.com/developers/documentation/v3/supported_locales).
| limit      | String| Optional: Number of business results to return. By default, it will return 20. Maximum is 50.
| offset     | Number| Optional: Offset the list of returned business results by this amount.
| sortBy     | String| Optional: Sort the results by one of the these modes: best_match, rating, review_count or distance. By default it's best_match. The rating sort is not strictly sorted by the rating value, but by an adjusted rating value that takes into account the number of ratings, similar to a bayesian average. This is so a business with 1 rating of 5 stars doesn’t immediately jump to the top.
| price      | Select| Optional: Pricing levels to filter the search result with: 1 = $, 2 = $$, 3 = $$$, 4 = $$$$. The price filter can be a list of comma delimited pricing levels. For example, "1, 2, 3" will filter the results to show the ones that are $, $$, or $$$.
| openNow    | Boolean| Optional: Default to false. When set to true, only return the businesses open now. Notice that open_at and open_now cannot be used together.
| openAt     | Datepicker| Optional: An integer represending the Unix time in the same timezone of the search location. If specified, it will return business open at the given time. Notice that open_at and open_now cannot be used together.
| attributes | List| Additional filters to restrict search results. Possible values are: hot_and_new, request_a_quote, waitlist_reservation, cashback, deals, gender_neutral_restrooms

## YelpAPI.getSingleBusiness
This endpoint returns the detail information of a business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| bussinessId| String| Required: The business ID.
| locale     | String| Optional: Specify the locale to return the autocomplete suggestions in. See the list of [supported locales](https://www.yelp.com/developers/documentation/v3/supported_locales).


## YelpAPI.getBusinessesByPhoneNumber
This endpoint returns a list of businesses based on the provided phone number. It is possible for more than one businesses having the same phone number (for example, chain stores with the same +1 800 phone number).

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| phone      | String| Required: Phone number of the business you want to search for. It must start with + and include the country code, like +14159083801.

## YelpAPI.getBusinessesByTransaction
This endpoint returns a list of businesses which support certain transactions.

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: Access Token obtained from getAccessToken endpoint.
| transactionType| String| Required: Valid values for transaction_type are: delivery.
| location       | String| Optional: Required when coordinate aren't provided. Address of the location you want to deliver to.
| coordinate     | Map   | Optional: Required if location is not provided. coordinate of the location you want to search near by coma separated.

## YelpAPI.getBusinessReviews
This endpoint returns the up to three reviews of a business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| bussinessId| String| Required: The business ID.
| locale     | String| Optional: Specify the interface locale; this determines the language of reviews to return. See the list of [supported locales](https://www.yelp.com/developers/documentation/v3/supported_locales).

## YelpAPI.getAutocomplete
This endpoint returns autocomplete suggestions for search keywords, businesses and categories, based on the input text.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| text       | String| Required: Text to return autocomplete suggestions for.
| coordinate     | Map   | Optional: Required if location is not provided. coordinate of the location you want to search near by coma separated.
| locale     | String| Optional: Specify the locale to return the autocomplete suggestions in. See the list of [supported locales](https://www.yelp.com/developers/documentation/v3/supported_locales).


## YelpAPI.getSingleEvent
This endpoint returns the detailed information of a Yelp event.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Access Token obtained from getAccessToken endpoint.
| eventId    | String| The event ID.
| locale     | String| Specify the locale to return the autocomplete suggestions in.

## YelpAPI.searchEvent
This endpoint returns events based on the provided search criteria.

| Field         | Type      | Description
|---------------|-----------|----------
| accessToken   | String    | Access Token obtained from getAccessToken endpoint.
| locale        | String    | Specify the locale to return the autocomplete suggestions in.
| offset        | Number    | Offset the list of returned business results by this amount.
| limit         | Number    | Number of business results to return. By default, it will return 20. Maximum is 50.
| sortBy        | Select    | Sort by either descending or ascending order. By default, it returns results in descending order. Possible values are: desc, asc
| sortOn        | Select    | Sort on popularity or time start. By default, sorts on popularity. Possible values are: popularity, time_start
| startDate     | DatePicker| Will return events that only begin at or after the specified time.
| endDate       | DatePicker| Will return events that only end at or before the specified time.
| categories    | List      | The category filter can be a list of comma delimited categories to get OR'd results that include the categories provided. 
| isFree        | Select    | Filter whether the events are free to attend. By default no filter is applied so both free and paid events will be returned.
| location      | String    | Specifies the combination of `address, neighborhood, city, state or zip, optional country` to be used when searching for events.
| coordinates   | Map       | The location you want to search nearby. 
| radius        | Number    | Search radius in meters.
| excludedEvents| List      | List of event ids. Events associated with these event ids in this list will not show up in the response.

## YelpAPI.getFeaturedEvent
This endpoint returns the featured event for a given location. Featured events are chosen by Yelp's community managers.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Access Token obtained from getAccessToken endpoint.
| locale     | String| Specify the locale to return the autocomplete suggestions in.
| location   | String| Specifies the combination of `address, neighborhood, city, state or zip, optional country` to be used when searching for events.
| coordinates| Map   | The location you want to search nearby. 

## YelpAPI.matchedBusinesses
These endpoints let you match business data from other sources against businesses on Yelp, based on minimal provided information.

| Field         | Type  | Description
|---------------|-------|----------
| accessToken   | String| Access Token obtained from getAccessToken endpoint.
| type          | Select| Must be best or lookup
| name          | String| The name of the business. Maximum length is 64; only digits, letters, spaces, and !#$%&+,­./:?@'are allowed.
| address1      | String| The first line of the business’s address. Maximum length is 64; only digits, letters, spaces, and ­’/#&,.: are allowed.
| address2      | String| The second line of the business’s address. Maximum length is 64; only digits, letters, spaces, and ­’/#&,.: are allowed.
| address3      | String| The third line of the business’s address. Maximum length is 64; only digits, letters, spaces, and ­’/#&,.: are allowed.
| city          | String| The city of the business. Maximum length is 64; only digits, letters, spaces, and ­’.() are allowed.
| state         | String| The ISO 3166-2 (with a few exceptions) state code of this business. Maximum length is 3.
| country       | String| The ISO 3166-1 alpha-2 country code of this business. Maximum length is 2.
| coordinates   | Map   | The location you want to search nearby. 
| phone         | String| The phone number of the business which can be submitted as (a) locally ­formatted with digits only (e.g., 016703080) or (b) internationally­ formatted with a leading + sign and digits only after (+35316703080). Maximum length is 32.
| postalCode    | String| The postal code of the business. Maximum length is 12.
| yelpBusinessId| String| Unique Yelp identifier of the business if available. Used as a hint when finding a matching business.

