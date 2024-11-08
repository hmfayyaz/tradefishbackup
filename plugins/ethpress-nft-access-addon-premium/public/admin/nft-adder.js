/**
 * Adds fields for contract addresses and tokens ids in WC product NFT data tab
 *
 * On submit, it gets all the comma'd values and splits them up into
 * address:id, because that's how the NFT API needs them.
 *
 * @package Ethpress_NFT_Access
 * @since 0.1.0
 */
jQuery(function ($) {
  var $pdata = $("#ethpress_nft_access_addon_product_data"),
    contracts,
    tokens,
    both = {},
    key;
  if (!$pdata) {
    return;
  }

  // var _ethpress_last_el = $("#ethpress_nft_access_addon_show_items");
  var _ethpress_index = 0;

  contracts = $("#ethpress_nft_access_addon_contract_addresses").val();
  tokens = $("#ethpress_nft_access_addon_token_ids").val();
  contracts = contracts.split(",");
  tokens = tokens.split(",");

  $(document).ready(ethpress_nft_access_addon_init);
  // proper init if loaded by ajax
  $(document).ajaxComplete(function (event, xhr, settings) {
    ethpress_nft_access_addon_init();
  });

  // contracts.forEach(function (contract, idx) {
  //   var token;
  //   if (contract && contract.trim && contract.trim()) {
  //     contract = contract.trim();
  //     if (!Array.isArray(both[contract])) {
  //       both[contract] = [];
  //     }
  //     token = tokens[idx] && tokens[idx].trim();
  //     if (token) {
  //       both[contract].push(token);
  //     }
  //   }
  // });
  // for (key in both) {
  //   addels(key, both[key].join(","));
  // }
  contracts.forEach(function (contract, idx) {
    var token;
    if (contract && contract.trim && contract.trim()) {
      token = tokens[idx] && tokens[idx].trim();
      addels(contract, token);
    }
  });

  $("#ethpress_nft_access_addon_add").click(function (e) {
    e.preventDefault();
    addels("", "");
  });

  $("form#post").on("submit", function (e) {
    var tokens = Array.from(
      document.querySelectorAll(".ethpress_nft_access_addon_token_id")
    );
    var contracts = Array.from(
      document.querySelectorAll(".ethpress_nft_access_addon_contract_address")
    );
    var t, i, token;
    $(".ethpress_nft_access_addon_token_id").remove();
    $(".ethpress_nft_access_addon_contract_address").remove();
    t = [];
    for (i = 0; i < contracts.length; i++) {
      t = tokens[i].value.split(",");
      for (token of t) {
        addels(contracts[i].value, token);
      }
    }
    $("#ethpress_nft_access_addon_contract_addresses").val(
      Array.from(
        document.querySelectorAll(".ethpress_nft_access_addon_contract_address")
      ).map(function (item, idx) {
        if (0 < idx) {
          return "," + $(item).val();
        }
        return $(item).val();
      })
    );
    $("#ethpress_nft_access_addon_token_ids").val(
      Array.from(
        document.querySelectorAll(".ethpress_nft_access_addon_token_id")
      ).map(function (item, idx) {
        var value = $(item).val();
        value = value.split(",");
        if (0 < idx) {
          return "," + $(item).val();
        }
        return $(item).val();
      })
    );
  });

  function addels(data1, data2) {
    let container = $("#ethpress_nft_access_addon_show_items");
    container
      .append(
        createField(
          "ethpress_nft_access_addon_contract_address[" + _ethpress_index + "]",
          window.ethpress_nft_access.nft_contract_address_label,
          data1.trim(),
          "ethpress_nft_access_addon_contract_address",
          "ethpress_nft_access_addon_contract_address[" + _ethpress_index + "]"
        )
      )
      .append(
        createField(
          "ethpress_nft_access_addon_token_id[" + _ethpress_index + "]",
          window.ethpress_nft_access.nft_token_id_label,
          data2.trim(),
          "ethpress_nft_access_addon_token_id",
          "ethpress_nft_access_addon_token_id[" + _ethpress_index + "]"
        )
      );
    _ethpress_index++;
  }

  function createField(id, label, value, cssclass, name) {
    return $(
      '<div class="components-form-token-field">' +
        '<label for="' +
        id +
        '" class="components-form-token-field__label">' +
        label +
        "</label>" +
        '<div class="components-form-token-field__input-container" tabindex="-1">' +
        '<input id="' +
        id +
        '" name="' +
        name +
        '" type="text" autocomplete="off" class="components-form-token-field__input ' +
        cssclass +
        '" aria-expanded="false" value="' +
        value +
        '">' +
        "</div>" +
        "</div>"
    );
  }

  function ethpress_nft_access_addon_init() {
    if (
      "undefined" !== typeof window.ethpress_nft_access &&
      window.ethpress_nft_access.initialized === true
    ) {
      return;
    }
    window.ethpress_nft_access.initialized = true;
    // Put your initialization code there
    $("#ethpress_nft_access_addon_add").click();
  }
});
