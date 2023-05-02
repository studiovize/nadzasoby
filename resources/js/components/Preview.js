import React from "react";

const priceClasses = 'text-xl font-bold text-red-500';

export default function Preview({
                                    thumbnail,
                                    title,
                                    content,
                                    category,
                                    price,
                                    tax_included,
                                    is_negotiable,
                                    is_price_in_content
                                }) {
    return (
        <div className="max-w-sm border flex flex-col justify-between gap-4 pb-4">
            <div>
                {thumbnail && (
                    <div className={'h-52 flex bg-gray-100'}>
                        <img className="w-full object-cover object-center" src={thumbnail}/>
                    </div>
                )}

                {!thumbnail && (
                    <div className={'h-52 flex bg-gray-100'}>
                        <img className="max-h-64 object-cover object-center m-auto" src="/icons/no-image.svg"/>
                    </div>
                )}
            </div>

            {title && <p className="block font-bold text-xl px-4">{title}</p>}

            {content && <p className="text-gray-700 text-base px-4 flex-1"
                           dangerouslySetInnerHTML={{__html: content.trim().split('\n').join('<br>')}}
            />}

            {(category || price) && (
                <div className="px-4 flex flex-col gap-2 items-start">
                    {category && (
                        <div
                            className="inline-block bg-gray-200 rounded px-3 py-1 text-sm font-semibold text-gray-700">
                            {category}
                        </div>
                    )}

                    {is_negotiable && (
                        <p className={priceClasses}>
                            Cena dohodou
                        </p>
                    )}

                    {is_price_in_content && (
                        <p className={priceClasses}>
                            Cena v textu
                        </p>
                    )}

                    {price && !is_negotiable && !is_price_in_content && (
                        <p className={priceClasses}>
                            {price} <small className="text-xs text-gray-400">{tax_included ? 's DPH' : 'bez DPH'}</small>
                        </p>
                    )}
                </div>
            )}
            {/*<div/>*/}
        </div>

    );
}
