<?php

return [
    /**
     * API Token Key (string)
     * Accepted value:
     * Live Token: https://myfatoorah.readme.io/docs/live-token
     * Test Token: https://myfatoorah.readme.io/docs/test-token
     */
    'api_key' => 'MT19_nmb7xrsTMxJmWlw5Q1AZ_t5cx1Om1Ad8gPH7EyngTCg51rdUvxUkWlEOteAsylQrSVvUO3NtlvUbbdKMxSdy_MVXVECqdPz8anSBebIJ33fBCm3ClpyCUyiooi7u4YKm7z-if-TKcy4xcALSARQHDPPizJsLV--CbCxNkrinEfV_C8oL0D2fWCeDRNOTk_CVEPEiDr_gCz59uo4yUfb734Ul119yOHfHO4qaF6_oF4kVZyJF2e0JpmH2jtYZzv8KZzlxJ6ZES3d3TEm2qBw48wnX5zU7lRbyOxS3X7yrAnkfu3iZKLeH_riar99Pa303hjFRS2yA-_xp8l1zsZSOYe-f62arSJpk7U0IFihzKw0dV1oUPGA8NbiobsajNjBiRIz_GSW3k-4gGkLBB0R1Pv4xXzk37Ej2O4oDA2vaIhbakHMyUi3nFNBs9Ob5SpzrmpreNu0XZWdA1On-gnBRJ9VH8XBdxAqzdnGlDXDkV4uHOqB9hi_eAymNc34Z7m1nrxAeh7OgUZeWi0uk7hHdz4GDNoH1z6XTu0C4IHhqQg6eXuBsE4uJ1Tvt1GaWQGmYzfiqvYiPTliZ3t7X-o0ZnSmWcepY466Dv2MKYPNgO3M7Ex60v88tN5XtADiBkI4oRi7szJw5gIYTaan2XbX6HUOYOYFplRrnTXMtFlYoFtHN58wGNX8vCEkBkToCxtl7Q',
    /**
     * Test Mode (boolean)
     * Accepted value: true for the test mode or false for the live mode
     */
    'test_mode' => false,
    /**
     * Country ISO Code (string)
     * Accepted value: KWT, SAU, ARE, QAT, BHR, OMN, JOD, or EGY.
     */
    'country_iso' => 'SAU',
    /**
     * Save card (boolean)
     * Accepted value: true if you want to enable save card options.
     * You should contact your account manager to enable this feature in your MyFatoorah account as well.
     */
    'save_card' => true,
    /**
     * Webhook secret key (string)
     * Enable webhook on your MyFatoorah account setting then paste the secret key here.
     * The webhook link is: https://{example.com}/myfatoorah/webhook
     */
    'webhook_secret_key' => 'PFE9JEdjPYB0hwzkJQCdkKsfh+bhxbtKBLZSIjNwzQpXzXMdirqYS17H2YfPPQbhDbIlYUddoKdykhTE1PStHA==',
    /**
     * Register Apple Pay (boolean)
     * Set it to true to show the Apple Pay on the checkout page.
     * First, verify your domain with Apple Pay before you set it to true.
     * You can either follow the steps here: https://docs.myfatoorah.com/docs/apple-pay#verify-your-domain-with-apple-pay or contact the MyFatoorah support team (tech@myfatoorah.com).
    */
    'register_apple_pay' => false
];
