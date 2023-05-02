import React, {useEffect, useState} from "react";
import {useForm} from "react-hook-form";
import axios from "axios";
import {useDropzone} from 'react-dropzone';

axios.defaults.headers.common = {
    'X-CSRF-TOKEN': Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

function getInputs(categories, conditions, units, areas) {
    // Types
    const typeOptions = [
        {
            value: 'sell',
            name: 'Nabídka'
        },
        {
            value: 'buy',
            name: 'Poptávka'
        }
    ];

    // Categories
    let categoryOptions = [
        {value: '', name: '-'}
    ];

    categories.forEach((cat) => {
        categoryOptions.push({
            name: cat.name,
            value: cat.id
        });
    });

    // Conditions
    const conditionOptions = conditions.map((condition) => {
        return {
            name: condition.name,
            value: condition.id
        }
    });

    // Units
    const unitOptions = units.map((unit) => {
        return {
            name: unit.name,
            value: unit.id
        }
    });

    let areaOptions = [];

    areas.forEach((area) => {
        let thisArea = {
            name: area.name,
            items: []
        };

        area.subareas.forEach((subArea) => {
            thisArea.items.push({
                value: subArea.id,
                name: subArea.name
            })
        });

        areaOptions.push(thisArea);
    });

    return [
        {
            element: 'text',
            type: 'text',
            label: 'Název',
            name: 'title'
        },
        {
            element: 'select',
            label: 'Typ inzerátu',
            name: 'type',
            options: typeOptions,
            disabled: true
        },
        {
            element: 'select',
            label: 'Kategorie',
            name: 'category',
            options: categoryOptions
        },
        {
            element: 'select',
            label: 'Stav',
            name: 'condition',
            options: conditionOptions
        },
        {
            element: 'text',
            type: 'text',
            label: 'Množství',
            name: 'amount'
        },
        {
            element: 'select',
            label: 'Jednotka',
            name: 'unit',
            options: unitOptions
        },
        {
            element: 'group-select',
            label: 'Okres',
            name: 'area',
            options: areaOptions
        },
        {
            element: 'text',
            type: 'text',
            label: 'Telefon',
            name: 'phone',
            helper: 'Telefon bude zájemcům zobrazen pouze po odemknutí inzerátu.'
        },
        {
            element: 'text',
            type: 'number',
            label: 'Cena',
            name: 'price',
        },
        {
            element: 'checkbox',
            label: 'Cena s DPH',
            name: 'tax_included'
        },
        {
            element: 'checkbox',
            label: 'Cena dohodou',
            name: 'is_negotiable'
        },
        {
            element: 'checkbox',
            label: 'Cena v textu',
            name: 'is_price_in_content'
        },
    ];
}

const inputBaseClassName = 'rounded focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 block mt-1 w-full disabled:opacity-50';
const inputClassName = 'border-gray-300 ' + inputBaseClassName;
const inputErrorClassName = 'border-red-300 ' + inputBaseClassName;

const plusIcon = `<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" class="w-12 m-auto"><path d="M1344 800v64q0 14-9 23t-23 9H960v352q0 14-9 23t-23 9h-64q-14 0-23-9t-9-23V896H480q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h352V416q0-14 9-23t23-9h64q14 0 23 9t9 23v352h352q14 0 23 9t9 23zm128 448V416q0-66-47-113t-113-47H480q-66 0-113 47t-47 113v832q0 66 47 113t113 47h832q66 0 113-47t47-113zm128-832v832q0 119-84 204t-204 84H480q-119 0-203-84t-85-204V416q0-119 85-203t203-85h832q119 0 204 85t84 203z" fill="currentColor"/></svg>`;

export default function FormEdit({onChange, formData, listingType}) {
    if (!window) return null;
    const {register, handleSubmit, formState: {errors}} = useForm();
    const [isNegotiable, setIsNegotiable] = useState(false);
    const [isPriceInContent, setIsPriceInContent] = useState(false);
    const [isSubmitting, setIsSubmitting] = useState(false);

    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        if (formData) {
            setIsNegotiable(formData.is_negotiable);
            setIsPriceInContent(formData.is_price_in_content);
            setLoaded(true);
        }
    }, [formData]);

    const onSubmit = (data) => {
        setIsSubmitting(true);

        axios.post(window.location.href, data)
            .then(function (response) {
                const {data: resData} = response;

                if (resData.status === 200) {
                    window.location.replace(resData.redirect_to);
                } else {
                    console.error(resData);
                }

                setIsSubmitting(false);
            })
            .catch(function (error) {
                setIsSubmitting(false);
                console.error(error.response.data);
            });
    };

    const categories = JSON.parse(window.categories);
    const conditions = JSON.parse(window.conditions);
    const units = JSON.parse(window.units);
    const areas = JSON.parse(window.areas);

    return loaded && (
        /* "handleSubmit" will validate your inputs before invoking "onSubmit" */
        <form onSubmit={handleSubmit(onSubmit)}
              className={`flex flex-col gap-4 transition-opacity ${isSubmitting ? 'opacity-50 pointer-events-none' : ''}`}>
            {listingType === 'buy' && (
                <div className="font-medium text-sm text-2red-500 border-2 border-red-500 bg-opacity-20 p-3">
                    Za poptávkový inzerát vám bude strženo 15 kreditů.
                </div>
            )}

            <div className="flex flex-col gap-8">
                <div className={'grid grid-cols-1 lg:grid-cols-2 gap-8'}>
                    {getInputs(categories, conditions, units, areas).map(({
                                                                              name,
                                                                              label,
                                                                              element,
                                                                              type,
                                                                              options,
                                                                              helper,
                                                                              disabled = false
                                                                          }, key) => {

                        return (
                            <div key={`Input: ${key}`} className={element === 'checkbox' ? 'self-center' : ''}>
                                {/*{element !== 'checkbox' && (*/}
                                <label htmlFor={name}
                                       className={'block font-bold text-sm text-gray-700'}>{label}</label>
                                {/*)}*/}

                                {element === 'text' && (
                                    <input type={type}
                                           {...register(name, {required: name !== 'price'})}
                                           id={name}
                                           className={errors[name] ? inputErrorClassName : inputClassName}
                                           key={`Input: ${key}`}
                                           onChange={(e) => onChange(name, e.target.value)}
                                           disabled={(isNegotiable || isPriceInContent) && name === 'price'}
                                           defaultValue={formData[name] ?? null}
                                    />
                                )}

                                {element === 'select' && (
                                    <select
                                        {...register(name, {required: !disabled})}
                                        id={name}
                                        className={errors[name] ? inputErrorClassName : inputClassName}
                                        onChange={(e) => {
                                            const val = e.target.options[e.target.selectedIndex].value;
                                            onChange(name, val);
                                        }}
                                        defaultValue={formData[name] ? formData[name] : ''}
                                        disabled={disabled}
                                    >
                                        {options.map((option, optKey) => {
                                            return (
                                                <option value={option.value}
                                                        key={`Sub Input: ${key} - ${optKey}`}
                                                >{option.name}</option>
                                            )
                                        })}
                                    </select>
                                )}

                                {element === 'group-select' && (
                                    <select
                                        {...register(name, {required: true})}
                                        id={name}
                                        className={errors[name] ? inputErrorClassName : inputClassName}
                                        onChange={(e) => onChange(name, e.target.options[e.target.selectedIndex].text)}
                                        defaultValue={formData[name] ? formData[name] : null}
                                    >
                                        {options.map((option, optKey) => {
                                            return (
                                                <optgroup label={option.name} key={`Input: ${key} - ${optKey}`}>
                                                    {option.items.map((optItem, optItemKey) => {
                                                        return (
                                                            <option value={optItem.value}
                                                                    key={`Sub Input: ${optKey} - ${optItemKey}`}>{optItem.name}</option>
                                                        )
                                                    })}
                                                </optgroup>
                                            )
                                        })}
                                    </select>
                                )}

                                {element === 'checkbox' && (
                                    <label htmlFor={name}
                                           className="inline-flex items-center font-medium mt-1 h-[42px]">
                                        <input type="checkbox"
                                               {...register(name)}
                                               id={name}
                                               value="1"
                                               className="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"
                                               defaultChecked={formData[name] && formData[name] === true}
                                               onChange={(e) => {
                                                   const {checked} = e.target;

                                                   if (name === 'is_negotiable') {
                                                       setIsNegotiable(checked);

                                                       if (checked) {
                                                           onChange('is_price_in_content', false);
                                                           setIsPriceInContent(false);
                                                       }

                                                       onChange('price', checked ? 'Cena dohodou' : document.querySelector('[name="price"]').value)
                                                   } else if (name === 'is_price_in_content') {
                                                       setIsPriceInContent(checked);

                                                       if (checked) {
                                                           onChange('is_negotiable', false);
                                                           setIsNegotiable(false);
                                                       }

                                                       onChange('price', checked ? 'Cena v textu' : document.querySelector('[name="price"]').value)
                                                   } else if (name === 'tax_included') {
                                                       // const {checked} = e.target;
                                                   }
                                                   onChange(name, checked);
                                               }}
                                        />
                                        <span className="ml-2 text-gray-700 text-sm">{label}</span>
                                    </label>
                                )}

                                {helper && (
                                    <p className="mt-2 text-sm text-gray-500">
                                        {helper}
                                    </p>
                                )}
                            </div>
                        )
                    })}
                </div>

                <div>
                    <label htmlFor={'content'} className={'block font-medium text-sm text-gray-700'}>Popis</label>
                    <textarea
                        {...register('content', {required: true})}
                        id={'content'}
                        className={errors['content'] ? inputErrorClassName : inputClassName}
                        rows="6"
                        onChange={({target: {value}}) => {
                            onChange('content', value.length > 100 ? value.substring(0, 100) + '...' : value);
                        }}
                        defaultValue={formData['content'] ?? null}
                    />
                </div>
            </div>

            <section>
                {/*<header className={'mb-2'}>*/}
                {/*    <h3 className={'text-3xl font-semibold'}>Fotografie</h3>*/}
                {/*</header>*/}
                <p className="italic text-gray-600">
                    Fotografie momentálně není možné měnit.
                </p>

            </section>

            <button type="submit"
                    className={'block w-full items-center bg-red-500 text-white border-0 py-2 focus:outline-none hover:bg-red-600 rounded text-base mt-4 md:mt-0'}
            >
                {!isSubmitting && `Uložit inzerát`}
                {isSubmitting && 'Prosím, vydržte...'}
            </button>
        </form>
    );
}
