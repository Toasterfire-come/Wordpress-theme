import React from 'react';
import { Button } from '../ui/button';

const PageHeader = ({ 
  title, 
  subtitle, 
  breadcrumb = [], 
  actions = [],
  className = "" 
}) => {
  return (
    <div className={`bg-white border-b border-slate-200 ${className}`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {/* Breadcrumb */}
        {breadcrumb.length > 0 && (
          <nav className="mb-4">
            <ol className="flex items-center space-x-2 text-sm">
              {breadcrumb.map((item, index) => (
                <React.Fragment key={index}>
                  {index > 0 && <span className="text-slate-400">/</span>}
                  {item.href ? (
                    <a href={item.href} className="text-slate-600 hover:text-slate-900">
                      {item.name}
                    </a>
                  ) : (
                    <span className="text-slate-900 font-medium">{item.name}</span>
                  )}
                </React.Fragment>
              ))}
            </ol>
          </nav>
        )}
        
        {/* Header Content */}
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between">
          <div className="min-w-0 flex-1">
            <h1 className="text-3xl font-bold text-slate-900 sm:truncate">
              {title}
            </h1>
            {subtitle && (
              <p className="mt-2 text-slate-600 max-w-2xl">
                {subtitle}
              </p>
            )}
          </div>
          
          {/* Actions */}
          {actions.length > 0 && (
            <div className="mt-4 sm:mt-0 sm:ml-4 flex space-x-3">
              {actions.map((action, index) => (
                <Button 
                  key={index}
                  variant={action.variant || 'default'}
                  size={action.size || 'default'}
                  onClick={action.onClick}
                  disabled={action.disabled}
                  className={action.className}
                >
                  {action.icon && <action.icon className="h-4 w-4 mr-2" />}
                  {action.label}
                </Button>
              ))}
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default PageHeader;