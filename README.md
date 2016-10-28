# YelpAPI Package
Yelp's Fusion API allows you to get the best local business information and user reviews of over million businesses in 32 countries.
* Domain: yelp.com
* Credentials: appId, appSecret

## How to get credentials: 
0. Sign up or Log in to [Yelp](https://www.yelp.com) 
1. Go to [Create App](https://www.yelp.com/developers/v3/manage_app)
2. In the create new app form, enter information about your app accordingly, then agree to Yelp API Terms of Use and Display Requirements. Then click the Submit button.
3. Now you can get the App ID and App Secret.

## TOC: 
* [getAccessToken](#getAccessToken)
* [getBusinesses](#getBusinesses)
* [getSingleBusiness](#getSingleBusiness)
* [getBusinessesByPhoneNumber](#getBusinessesByPhoneNumber)
* [getBusinessesByTransaction](#getBusinessesByTransaction)
* [getBusinessReviews](#getBusinessReviews)
* [getAutocomplete](#getAutocomplete)
 
<a name="getAccessToken"/>
## YelpAPI.getAccessToken
Allows to get an access token.

| Field    | Type       | Description
|----------|------------|----------
| appId    | credentials| Required: Your App ID obtained from Yelp.
| appSecret| credentials| Required: Your App Secret obtained from Yelp.

<a name="getBusinesses"/>
## YelpAPI.getBusinesses
This endpoint returns up to 1000 businesses based on the provided search criteria. It has some basic information about the business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| term       | String| Optional: Search term (e.g. "food", "restaurants"). If term isn’t included we search everything. The term keyword also accepts business names such as "Starbucks".
| location   | String| Optional: Required if either latitude or longitude is not provided. Specifies the combination of "address, neighborhood, city, state or zip, optional country" to be used when searching for businesses.
| latitude   | String| Optional: Required if location is not provided. Latitude of the location you want to search near by.
| longitude  | String| Optional: Required if location is not provided. Latitude of the location you want to search near by.
| radius     | String| Optional: Search radius in meters. If the value is too large, a AREA_TOO_LARGE error may be returned. The max value is 40000 meters (25 miles).
| categories | String| Optional: Categories to filter the search results with. See the list of supported categories. The category filter can be a list of comma delimited categories. For example, "bars,french" will filter by Bars and French. The category identifier should be used (for example "discgolf", not "Disc Golf").
| locale     | String| Optional: Specify the locale to return the business information in.
| limit      | String| Optional: Number of business results to return. By default, it will return 20. Maximum is 50.
| offset     | String| Optional: Offset the list of returned business results by this amount.
| sortBy     | String| Optional: Sort the results by one of the these modes: best_match, rating, review_count or distance. By default it's best_match. The rating sort is not strictly sorted by the rating value, but by an adjusted rating value that takes into account the number of ratings, similar to a bayesian average. This is so a business with 1 rating of 5 stars doesn’t immediately jump to the top.
| price      | String| Optional: Pricing levels to filter the search result with: 1 = $, 2 = $$, 3 = $$$, 4 = $$$$. The price filter can be a list of comma delimited pricing levels. For example, "1, 2, 3" will filter the results to show the ones that are $, $$, or $$$.
| openNow    | String| Optional: Default to false. When set to true, only return the businesses open now. Notice that open_at and open_now cannot be used together.
| openAt     | String| Optional: An integer represending the Unix time in the same timezone of the search location. If specified, it will return business open at the given time. Notice that open_at and open_now cannot be used together.
| attributes | String| Optional: Additional filters to search businesses. You can use multiple attribute filters at the same time by providing a comma separated string, like this "attribute1,attribute2". Currently, the valid values are hot_and_new and deals.

<a name="getSingleBusiness"/>
## YelpAPI.getSingleBusiness
This endpoint returns the detail information of a business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| bussinessId| String| Required: The business ID.

<a name="getBusinessesByPhoneNumber"/>
## YelpAPI.getBusinessesByPhoneNumber
This endpoint returns a list of businesses based on the provided phone number. It is possible for more than one businesses having the same phone number (for example, chain stores with the same +1 800 phone number).

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| phone      | String| Required: Phone number of the business you want to search for. It must start with + and include the country code, like +14159083801.

<a name="getBusinessesByTransaction"/>
## YelpAPI.getBusinessesByTransaction
This endpoint returns a list of businesses which support certain transactions.

| Field          | Type  | Description
|----------------|-------|----------
| accessToken    | String| Required: Access Token obtained from getAccessToken endpoint.
| transactionType| String| Required: Valid values for transaction_type are: delivery.
| location       | String| Optional: Required when latitude and longitude aren't provided. Address of the location you want to deliver to.
| latitude       | String| Optional: Required when location isn't provided. Latitude of the location you want to deliver to.
| longitude      | String| Optional: Required when location isn't provided. Longitude of the location you want to deliver to.

<a name="getBusinessReviews"/>
## YelpAPI.getBusinessReviews
This endpoint returns the up to three reviews of a business.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| bussinessId| String| Required: The business ID.
| locale     | String| Optional: Specify the interface locale; this determines the language of reviews to return.

<a name="getAutocomplete"/>
## YelpAPI.getAutocomplete
This endpoint returns autocomplete suggestions for search keywords, businesses and categories, based on the input text.

| Field      | Type  | Description
|------------|-------|----------
| accessToken| String| Required: Access Token obtained from getAccessToken endpoint.
| text       | String| Required: Text to return autocomplete suggestions for.
| latitude   | String| Required: Required if want to get autocomplete suggestions for businesses. Latitude of the location to look for business autocomplete suggestions.
| longitude  | String| Required: Required if want to get autocomplete suggestions for businesses. Longitude of the location to look for business autocomplete suggestions.
| locale     | String| Optional: Specify the locale to return the autocomplete suggestions in.

