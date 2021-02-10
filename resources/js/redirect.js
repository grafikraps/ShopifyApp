import createApp from '@shopify/app-bridge';
import { Redirect } from '@shopify/app-bridge/actions';

const { API_KEY, SHOP_ORIGIN, REDIRECT_URI } = window.Shopify;

const params = new URLSearchParams({
  shop: SHOP_ORIGIN,
});

const grantUrl = `${REDIRECT_URI}?${params.toString()}`;

if (window.top === window.self) {
  window.location.assign(grantUrl);
} else {
  const app = createApp({
    apiKey: API_KEY,
    shopOrigin: SHOP_ORIGIN,
  });

  Redirect.create(app).dispatch(Redirect.Action.REMOTE, grantUrl);
}
